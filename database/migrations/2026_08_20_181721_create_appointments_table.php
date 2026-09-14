<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->text('reason')->nullable();
            $table->text('notes')->nullable()->comment('Internal staff-only notes');
            $table->decimal('consultation_fee', 10, 2)->default(0.00);
            $table->foreignId('booked_by')->nullable()->constrained('users')->nullOnDelete()->comment('Receptionist who created walk-in');
            $table->text('cancelled_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Prevent double-booking at DB level
            $table->unique(['doctor_profile_id', 'appointment_date', 'appointment_time'], 'no_double_booking');
            $table->index(['doctor_profile_id', 'appointment_date'], 'idx_doctor_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
