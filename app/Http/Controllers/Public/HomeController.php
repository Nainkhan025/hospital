<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DoctorProfile;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $departments = Department::active()->take(6)->get();
        $doctors     = DoctorProfile::active()
            ->with('user', 'department')
            ->take(6)
            ->get();

        $stats = [
            'doctors'     => DoctorProfile::active()->count(),
            'departments' => Department::active()->count(),
            'patients'    => User::role('patient')->count(),
        ];

        return view('public.home', compact('departments', 'doctors', 'stats'));
    }
}
