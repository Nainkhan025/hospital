<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        $doctors     = DoctorProfile::with('user')->get();

        $appointments = Appointment::with('patient', 'doctor.user', 'department')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->department_id, fn($q) => $q->where('department_id', $request->department_id))
            ->when($request->doctor_id, fn($q) => $q->where('doctor_profile_id', $request->doctor_id))
            ->when($request->date, fn($q) => $q->whereDate('appointment_date', $request->date))
            ->latest('appointment_date')
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments', 'departments', 'doctors'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('patient', 'doctor.user', 'department', 'medicalRecord', 'invoice');
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $departments = Department::all();
        $doctors     = DoctorProfile::with('user')->get();
        return view('admin.appointments.edit', compact('appointment', 'departments', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment #' . $appointment->id . ' status updated to ' . $request->status);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success', 'Appointment deleted successfully.');
    }
}
