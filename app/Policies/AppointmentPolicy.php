<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'doctor', 'patient', 'receptionist']);
    }

    public function view(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['super_admin', 'admin', 'receptionist'])) {
            return true;
        }

        if ($user->isDoctor() && $appointment->doctor_profile_id === $user->doctorProfile?->id) {
            return true;
        }

        if ($user->isPatient() && $appointment->patient_id === $user->id) {
            return true;
        }

        return false;
    }

    public function cancel(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['super_admin', 'admin', 'receptionist'])) {
            return true;
        }

        if ($user->isPatient() && $appointment->patient_id === $user->id) {
            return in_array($appointment->status, ['pending', 'confirmed']);
        }

        return false;
    }

    public function updateStatus(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['super_admin', 'admin', 'receptionist'])) {
            return true;
        }

        if ($user->isDoctor() && $appointment->doctor_profile_id === $user->doctorProfile?->id) {
            return true;
        }

        return false;
    }
}
