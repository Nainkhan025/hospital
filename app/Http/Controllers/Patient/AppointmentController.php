<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $appointments = $user->appointments()
            ->with('doctor.user', 'department')
            ->latest('appointment_date')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('patient.appointments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id'     => 'required|exists:departments,id',
            'doctor_profile_id' => 'required|exists:doctor_profiles,id',
            'appointment_date'  => 'required|date|after_or_equal:today',
            'appointment_time'  => 'required',
            'reason'            => 'nullable|string|max:1000',
        ]);

        $doctor = \App\Models\DoctorProfile::findOrFail($validated['doctor_profile_id']);

        $exists = Appointment::where('doctor_profile_id', $validated['doctor_profile_id'])
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['appointment_time' => 'This slot is already booked. Please choose a different time.']);
        }

        try {
            $appointment = Appointment::create([
                'patient_id'        => Auth::id(),
                'doctor_profile_id' => $validated['doctor_profile_id'],
                'department_id'     => $validated['department_id'],
                'appointment_date'  => $validated['appointment_date'],
                'appointment_time'  => $validated['appointment_time'],
                'status'            => 'pending',
                'reason'            => $validated['reason'] ?? null,
                'consultation_fee'  => $doctor->consultation_fee ?? 0.00,
                'booked_by'         => Auth::id(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['appointment_time' => 'This doctor slot is unavailable at the selected date & time. Please choose another slot.']);
        }

        return redirect()->route('patient.appointments.show', $appointment->id)
            ->with('success', 'Appointment requested successfully.');
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $appointment = $user->appointments()
            ->with('doctor.user', 'department')
            ->findOrFail($id);

        return view('patient.appointments.show', compact('appointment'));
    }

    public function cancel(string $id)
    {
        $user = Auth::user();
        $appointment = $user->appointments()->findOrFail($id);

        if (in_array($appointment->status, ['pending', 'confirmed'])) {
            $appointment->update(['status' => 'cancelled']);
            return back()->with('success', 'Appointment cancelled successfully.');
        }

        return back()->with('error', 'This appointment cannot be cancelled.');
    }
}
