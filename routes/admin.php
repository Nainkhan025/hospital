<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:super_admin|admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Departments
        Route::resource('departments', DepartmentController::class);

        // Doctors
        Route::resource('doctors', DoctorController::class);

        // Appointments
        Route::resource('appointments', AppointmentController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    });
