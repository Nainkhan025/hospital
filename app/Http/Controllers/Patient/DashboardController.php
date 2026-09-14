<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $upcoming = $user->appointments()->upcoming()->with('doctor.user', 'department')->take(5)->get();
        $past     = $user->appointments()->past()->with('doctor.user', 'department')->latest('appointment_date')->take(5)->get();

        return view('patient.dashboard', compact('upcoming', 'past'));
    }
}
