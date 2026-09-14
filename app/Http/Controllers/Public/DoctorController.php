<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DoctorProfile;

class DoctorController extends Controller
{
    public function index()
    {
        $departments = Department::active()->get();
        $doctors     = DoctorProfile::active()
            ->with('user', 'department')
            ->when(request('department'), fn($q) => $q->where('department_id', request('department')))
            ->when(request('search'), fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', '%' . request('search') . '%')))
            ->paginate(12);

        return view('public.doctors.index', compact('departments', 'doctors'));
    }

    public function show(int $id)
    {
        $doctor = DoctorProfile::active()->with('user', 'department', 'schedules')->findOrFail($id);
        return view('public.doctors.show', compact('doctor'));
    }
}
