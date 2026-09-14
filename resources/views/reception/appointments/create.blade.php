<x-dashboard-layout>
    <x-slot name="title">Book Walk-In Appointment</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Walk-In Patient Registration</h1>
        <a href="{{ route('reception.appointments.index') }}" class="btn-outline-sm">Back</a>
    </x-slot>

    <div class="max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('reception.appointments.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="form-label">Select Patient</label>
                    <select name="patient_id" class="form-select" required>
                        <option value="">Select registered patient...</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} ({{ $p->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Consultant / Doctor</label>
                        <select name="doctor_profile_id" class="form-select" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}" {{ old('doctor_profile_id') == $doc->id ? 'selected' : '' }}>{{ $doc->user->name }} ({{ $doc->specialization }})</option>
                            @endforeach
                        </select>
                        @error('doctor_profile_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Appointment Date</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date', today()->format('Y-m-d')) }}" class="form-input" required>
                        @error('appointment_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Appointment Time</label>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time', now()->format('H:i')) }}" class="form-input" required>
                        @error('appointment_time') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Reason / Notes</label>
                    <textarea name="reason" rows="3" class="form-input resize-none" placeholder="Walk-in consultation notes...">{{ old('reason') }}</textarea>
                    @error('reason') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-[#E4E4E7] flex justify-end gap-2">
                    <a href="{{ route('reception.appointments.index') }}" class="btn-outline-sm">Cancel</a>
                    <button type="submit" class="btn-primary">Confirm Walk-In Booking</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
