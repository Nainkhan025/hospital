<?php

use App\Http\Controllers\Reception\DashboardController;
use App\Http\Controllers\Reception\AppointmentController;
use App\Http\Controllers\Reception\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:receptionist'])
    ->prefix('reception')
    ->name('reception.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('appointments', AppointmentController::class)->only(['index', 'create', 'store', 'edit', 'update']);
        Route::patch('/appointments/{appointment}/checkin', [AppointmentController::class, 'checkIn'])->name('appointments.checkin');

        Route::resource('invoices', InvoiceController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('/invoices/{invoice}/payments', [InvoiceController::class, 'recordPayment'])->name('invoices.payments');
        Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    });
