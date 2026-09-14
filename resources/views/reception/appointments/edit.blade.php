<x-dashboard-layout>
    <x-slot name="title">Edit Reception Appointment #APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">Edit Walk-in / Appointment</h1>
            <a href="{{ route('reception.appointments.index') }}" class="btn-outline-sm">Back</a>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('reception.appointments.update', $appointment->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">Patient</label>
                    <select name="patient_id" class="form-select" required>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} ({{ $patient->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $appointment->department_id) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Doctor</label>
                        <select name="doctor_profile_id" class="form-select" required>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}" {{ old('doctor_profile_id', $appointment->doctor_profile_id) == $doc->id ? 'selected' : '' }}>
                                    {{ $doc->user->name }} ({{ $doc->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Date</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">Time</label>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" class="form-input" required>
                    </div>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                            <option value="{{ $st }}" {{ old('status', $appointment->status) === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Reason / Notes</label>
                    <textarea name="reason" rows="3" class="form-textarea" placeholder="Chief complaints or visit reason...">{{ old('reason', $appointment->reason) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E4E4E7]">
                    <a href="{{ route('reception.appointments.index') }}" class="btn-outline-sm py-2 px-4">Cancel</a>
                    <button type="submit" class="btn-primary-sm py-2 px-4">Update Appointment</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
