<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\DepartmentController;
use App\Http\Controllers\Public\DoctorController as PublicDoctorController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/{slug}', [DepartmentController::class, 'show'])->name('departments.show');
Route::get('/doctors', [PublicDoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{id}', [PublicDoctorController::class, 'show'])->name('doctors.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// ── Dashboard (role-redirect) ─────────────────────────────────────
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    return redirect($user->dashboardRoute());
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Shared Authenticated Routes ───────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/documents/{media}', [DocumentController::class, 'download'])->name('documents.download');
});

// ── Role-specific dashboards ──────────────────────────────────────
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/doctor.php';
require __DIR__ . '/patient.php';
require __DIR__ . '/reception.php';
