<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DoctorProfile;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = DoctorProfile::with('user', 'department')->paginate(15);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::active()->get();
        return view('admin.doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:8',
            'department_id'    => 'required|exists:departments,id',
            'specialization'   => 'required|string|max:255',
            'qualifications'   => 'required|string|max:255',
            'years_experience' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'bio'              => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('doctor');

            $profile = DoctorProfile::create([
                'user_id'          => $user->id,
                'department_id'    => $request->department_id,
                'specialization'   => $request->specialization,
                'qualifications'   => $request->qualifications,
                'years_experience' => $request->years_experience,
                'consultation_fee' => $request->consultation_fee,
                'bio'              => $request->bio,
                'is_active'        => true,
            ]);

            // Create default schedule (Mon-Fri 09:00 - 17:00)
            for ($day = 1; $day <= 5; $day++) {
                DoctorSchedule::create([
                    'doctor_profile_id' => $profile->id,
                    'day_of_week'       => $day,
                    'start_time'        => '09:00:00',
                    'end_time'          => '17:00:00',
                    'is_available'      => true,
                ]);
            }
        });

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor registered successfully with default weekday schedules.');
    }

    public function edit(DoctorProfile $doctor)
    {
        $departments = Department::active()->get();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, DoctorProfile $doctor)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $doctor->user_id,
            'department_id'    => 'required|exists:departments,id',
            'specialization'   => 'required|string|max:255',
            'qualifications'   => 'required|string|max:255',
            'years_experience' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'bio'              => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $doctor) {
            $doctor->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $doctor->user->update(['password' => Hash::make($request->password)]);
            }

            $doctor->update([
                'department_id'    => $request->department_id,
                'specialization'   => $request->specialization,
                'qualifications'   => $request->qualifications,
                'years_experience' => $request->years_experience,
                'consultation_fee' => $request->consultation_fee,
                'bio'              => $request->bio,
                'is_active'        => $request->has('is_active'),
            ]);
        });

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor profile updated successfully.');
    }

    public function destroy(DoctorProfile $doctor)
    {
        DB::transaction(function () use ($doctor) {
            $user = $doctor->user;
            $doctor->delete();
            $user->delete();
        });

        return back()->with('success', 'Doctor account deleted successfully.');
    }
}
