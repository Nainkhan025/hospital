<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\DoctorProfile;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookAppointment extends Component
{
    public int $step = 1;

    // Form inputs
    public ?int $department_id = null;
    public ?int $doctor_profile_id = null;
    public ?string $appointment_date = null;
    public ?string $appointment_time = null;
    public string $reason = '';

    // Guest / Patient Details
    public string $patient_name = '';
    public string $patient_email = '';
    public string $patient_phone = '';

    public function mount(?int $selectedDoctor = null, ?int $selectedDepartment = null)
    {
        if ($selectedDepartment) {
            $this->department_id = $selectedDepartment;
            $this->step = 2;
        }

        if ($selectedDoctor) {
            $doctor = DoctorProfile::find($selectedDoctor);
            if ($doctor) {
                $this->doctor_profile_id = $doctor->id;
                $this->department_id = $doctor->department_id;
                $this->step = 3;
            }
        }

        if (Auth::check()) {
            $user = Auth::user();
            $this->patient_name  = $user->name;
            $this->patient_email = $user->email;
            $this->patient_phone = $user->phone ?? '';
        }
    }

    public function selectDepartment(int $id)
    {
        $this->department_id = $id;
        $this->doctor_profile_id = null;
        $this->appointment_date = null;
        $this->appointment_time = null;
        $this->step = 2;
    }

    public function selectDoctor(int $id)
    {
        $this->doctor_profile_id = $id;
        $this->appointment_date = null;
        $this->appointment_time = null;
        $this->step = 3;
    }

    public function selectDate(string $date)
    {
        $this->appointment_date = $date;
        $this->appointment_time = null;
    }

    public function selectTime(string $time)
    {
        $this->appointment_time = $time;
    }

    public function goToStep(int $targetStep)
    {
        if ($targetStep < $this->step) {
            $this->step = $targetStep;
        }
    }

    public function nextStep()
    {
        if ($this->step === 3) {
            $this->validate([
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
            ]);
            $this->step = 4;
        }
    }

    public function getAvailableDatesProperty(): array
    {
        if (!$this->doctor_profile_id) {
            return [];
        }

        $doctor = DoctorProfile::find($this->doctor_profile_id);
        if (!$doctor) return [];

        // Check recurring schedule day_of_week
        $activeDays = $doctor->schedules()
            ->where('is_available', true)
            ->whereNull('specific_date')
            ->pluck('day_of_week')
            ->toArray();

        $dates = [];
        $start = Carbon::today();
        for ($i = 0; $i < 14; $i++) {
            $current = $start->copy()->addDays($i);
            if (in_array($current->dayOfWeek, $activeDays)) {
                $dates[] = [
                    'formatted' => $current->format('Y-m-d'),
                    'day_name'  => $current->format('D'),
                    'day_num'   => $current->format('d'),
                    'month'     => $current->format('M'),
                ];
            }
        }

        return $dates;
    }

    public function getAvailableSlotsProperty(): array
    {
        if (!$this->doctor_profile_id || !$this->appointment_date) {
            return [];
        }

        $doctor = DoctorProfile::find($this->doctor_profile_id);
        if (!$doctor) return [];

        $date = Carbon::parse($this->appointment_date);
        $dayOfWeek = $date->dayOfWeek;

        $schedule = $doctor->schedules()
            ->where('is_available', true)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$schedule) {
            return [];
        }

        $startTime = Carbon::parse($this->appointment_date . ' ' . $schedule->start_time);
        $endTime   = Carbon::parse($this->appointment_date . ' ' . $schedule->end_time);

        // Fetch existing booked appointments for this doctor & date
        $bookedTimes = Appointment::where('doctor_profile_id', $this->doctor_profile_id)
            ->whereDate('appointment_date', $this->appointment_date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->map(fn($t) => Carbon::parse($t)->format('H:i'))
            ->toArray();

        $slots = [];
        $slotDuration = 30; // 30 minute slots

        while ($startTime->lt($endTime)) {
            $slotFormatted = $startTime->format('H:i');
            $isBooked = in_array($slotFormatted, $bookedTimes);
            $isPast = $date->isToday() && $startTime->isPast();

            if (!$isBooked && !$isPast) {
                $slots[] = [
                    'raw'    => $slotFormatted,
                    'display'=> $startTime->format('g:i A'),
                ];
            }

            $startTime->addMinutes($slotDuration);
        }

        return $slots;
    }

    public function submitBooking()
    {
        $this->validate([
            'department_id'      => 'required|exists:departments,id',
            'doctor_profile_id'  => 'required|exists:doctor_profiles,id',
            'appointment_date'   => 'required|date|after_or_equal:today',
            'appointment_time'   => 'required',
            'patient_name'       => 'required|string|max:255',
            'patient_email'      => 'required|email|max:255',
            'patient_phone'      => 'nullable|string|max:20',
            'reason'             => 'nullable|string|max:1000',
        ]);

        $doctor = DoctorProfile::findOrFail($this->doctor_profile_id);

        // Determine patient_id
        if (Auth::check()) {
            $patientId = Auth::id();
        } else {
            $patientUser = \App\Models\User::where('email', $this->patient_email)->first();
            if (!$patientUser) {
                $patientUser = \App\Models\User::create([
                    'name'     => $this->patient_name,
                    'email'    => $this->patient_email,
                    'phone'    => $this->patient_phone,
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
                ]);
                $patientUser->assignRole('patient');
            }
            $patientId = $patientUser->id;
        }

        // Double booking check
        $exists = Appointment::where('doctor_profile_id', $this->doctor_profile_id)
            ->whereDate('appointment_date', $this->appointment_date)
            ->where('appointment_time', $this->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            $this->addError('appointment_time', 'This time slot was just booked by another patient. Please select another slot.');
            $this->step = 3;
            return;
        }

        $appointment = Appointment::create([
            'patient_id'        => $patientId,
            'doctor_profile_id' => $this->doctor_profile_id,
            'department_id'     => $this->department_id,
            'appointment_date'  => $this->appointment_date,
            'appointment_time'  => $this->appointment_time,
            'status'            => 'pending',
            'reason'            => $this->reason,
            'consultation_fee'  => $doctor->consultation_fee ?? 0.00,
        ]);

        try {
            if ($appointment->patient && $appointment->patient->email) {
                \Illuminate\Support\Facades\Mail::to($appointment->patient->email)->send(new \App\Mail\AppointmentBooked($appointment));
            }
        } catch (\Throwable $e) {
            // Log mail failure gracefully
        }

        session()->flash('success', 'Your appointment has been successfully requested! Reference #' . $appointment->id);

        if (Auth::check()) {
            return redirect()->route('patient.dashboard');
        }

        return redirect()->route('home');
    }

    public function render()
    {
        $departments = Department::active()->get();
        $doctors = $this->department_id
            ? DoctorProfile::active()->where('department_id', $this->department_id)->with('user')->get()
            : collect();

        $selectedDept   = Department::find($this->department_id);
        $selectedDoctor = DoctorProfile::with('user')->find($this->doctor_profile_id);

        return view('livewire.book-appointment', compact('departments', 'doctors', 'selectedDept', 'selectedDoctor'));
    }
}
