<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with('patient', 'doctor.user', 'department')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->date, fn($q) => $q->whereDate('appointment_date', $request->date), fn($q) => $q->whereDate('appointment_date', today()))
            ->orderBy('appointment_time')
            ->paginate(20);

        return view('reception.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients    = User::role('patient')->select('id', 'name', 'email', 'phone')->orderBy('name')->get();
        $departments = Department::active()->get();
        $doctors     = DoctorProfile::active()->with('user')->get();

        return view('reception.appointments.create', compact('patients', 'departments', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|exists:users,id',
            'doctor_profile_id' => 'required|exists:doctor_profiles,id',
            'department_id'     => 'required|exists:departments,id',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required',
            'reason'            => 'nullable|string|max:1000',
        ]);

        $exists = Appointment::where('doctor_profile_id', $validated['doctor_profile_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['appointment_time' => 'This doctor slot is already booked. Please choose a different time.']);
        }

        $doctor = DoctorProfile::findOrFail($validated['doctor_profile_id']);
        $validated['consultation_fee'] = $doctor->consultation_fee;
        $validated['status']           = 'confirmed'; // Walk-ins confirmed by default

        try {
            Appointment::create($validated);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['appointment_time' => 'Slot unavailable. Please select another time.']);
        }

        return redirect()->route('reception.appointments.index')->with('success', 'Walk-in appointment registered successfully.');
    }

    public function edit(Appointment $appointment)
    {
        $patients    = User::role('patient')->select('id', 'name', 'email', 'phone')->orderBy('name')->get();
        $departments = Department::active()->get();
        $doctors     = DoctorProfile::active()->with('user')->get();

        return view('reception.appointments.edit', compact('appointment', 'patients', 'departments', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|exists:users,id',
            'doctor_profile_id' => 'required|exists:doctor_profiles,id',
            'department_id'     => 'required|exists:departments,id',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required',
            'status'            => 'required|in:pending,confirmed,completed,cancelled,no_show',
            'reason'            => 'nullable|string|max:1000',
        ]);

        // Check slot collision when updating slot
        $exists = Appointment::where('doctor_profile_id', $validated['doctor_profile_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('id', '!=', $appointment->id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['appointment_time' => 'The selected slot is already booked for this doctor.']);
        }

        $doctor = DoctorProfile::findOrFail($validated['doctor_profile_id']);
        $validated['consultation_fee'] = $doctor->consultation_fee;

        try {
            $appointment->update($validated);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['appointment_time' => 'Slot unavailable. Please select another time.']);
        }

        return redirect()->route('reception.appointments.index')->with('success', 'Appointment #' . $appointment->id . ' updated successfully.');
    }

    public function checkIn(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);
        return back()->with('success', 'Patient checked in successfully for appointment #' . $appointment->id);
    }
}
