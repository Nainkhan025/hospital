<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctorProfile;

        $today_appointments = $doctor
            ? $doctor->appointments()->where('appointment_date', today())->with('patient')->get()
            : collect();

        $upcoming_count = $doctor
            ? $doctor->appointments()->upcoming()->count()
            : 0;

        return view('doctor.dashboard', compact('today_appointments', 'upcoming_count'));
    }
}
