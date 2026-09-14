<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\Department;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'appointments_today' => Appointment::where('appointment_date', today())->count(),
            'total_doctors'      => DoctorProfile::active()->count(),
            'total_departments'  => Department::where('is_active', true)->count(),
            'total_patients'     => User::role('patient')->count(),
        ];

        $recent_appointments = Appointment::with('patient', 'doctor.user', 'department')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_appointments'));
    }
}
