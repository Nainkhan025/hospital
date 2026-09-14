<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::active()->get();
        return view('public.departments.index', compact('departments'));
    }

    public function show(string $slug)
    {
        $department = Department::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $doctors    = $department->doctorProfiles()->active()->with('user')->get();
        return view('public.departments.show', compact('department', 'doctors'));
    }
}
