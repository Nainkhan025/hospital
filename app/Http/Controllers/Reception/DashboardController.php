<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $today_appointments = Appointment::where('appointment_date', today())
            ->with('patient', 'doctor.user', 'department')
            ->orderBy('appointment_time')
            ->get();

        return view('reception.dashboard', compact('today_appointments'));
    }
}
