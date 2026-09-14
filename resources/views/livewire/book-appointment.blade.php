<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

    <!-- Progress Indicator -->
    <div class="mb-10 border-b border-[#E4E4E7] dark:border-[#1F2937] pb-6 flex items-center justify-between">
        <div class="flex items-center gap-6">
            @foreach([
                1 => 'Department',
                2 => 'Consultant',
                3 => 'Date & Time',
                4 => 'Review & Confirm'
            ] as $s => $label)
                <button wire:click="goToStep({{ $s }})"
                        @if($step < $s) disabled @endif
                        class="flex items-center gap-2 text-xs uppercase font-medium tracking-wider transition-colors"
                        style="font-family:'Geist',sans-serif; cursor: {{ $step > $s ? 'pointer' : 'default' }};">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold {{ $step === $s ? 'bg-[#18181B] dark:bg-white text-white dark:text-[#18181B]' : ($step > $s ? 'bg-[#E4E4E7] dark:bg-[#1F2937] text-[#18181B] dark:text-[#F9FAFB]' : 'bg-[#F4F4F5] dark:bg-[#111827] text-[#71717A] dark:text-gray-400') }}">
                        {{ $s }}
                    </span>
                    <span class="hidden sm:inline {{ $step === $s ? 'text-[#18181B] dark:text-white font-semibold' : ($step > $s ? 'text-[#71717A] dark:text-gray-300' : 'text-[#A1A1AA] dark:text-gray-500') }}">{{ $label }}</span>
                </button>
            @endforeach
        </div>
        <span class="text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">Step {{ $step }} of 4</span>
    </div>

    <!-- STEP 1: Select Department -->
    @if($step === 1)
        <div class="reveal in-view">
            <h2 class="section-heading mb-2" style="font-size: 1.75rem;">Select Department</h2>
            <p class="section-subheading mb-8" style="margin-top: 0.25rem;">Choose the medical specialty for your consultation.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-[#E4E4E7] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl overflow-hidden">
                @foreach($departments as $dept)
                    <button wire:click="selectDepartment({{ $dept->id }})"
                            class="bg-white dark:bg-[#111827] p-6 text-left hover:bg-[#FAFAFA] dark:hover:bg-[#1F2937]/60 transition-colors group flex flex-col justify-between"
                            style="min-height: 140px;">
                        <div>
                            <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:0.9375rem;" class="text-[#18181B] dark:text-white">{{ $dept->name }}</h3>
                            <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;margin-top:0.375rem;line-height:1.5;" class="text-[#71717A] dark:text-gray-400">{{ Str::limit($dept->description, 70) }}</p>
                        </div>
                        <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-[#18181B] dark:text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            Select
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- STEP 2: Select Doctor -->
    @if($step === 2)
        <div class="reveal in-view">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <span class="section-eyebrow">{{ $selectedDept->name ?? 'Department' }}</span>
                    <h2 class="section-heading" style="font-size: 1.75rem;">Select Consultant</h2>
                </div>
                <button wire:click="goToStep(1)" class="btn-outline-sm">Change Department</button>
            </div>

            @if($doctors->isEmpty())
                <div class="p-12 text-center bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                    No doctors available in this department right now.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($doctors as $doc)
                        <div wire:click="selectDoctor({{ $doc->id }})"
                             class="hms-card p-5 cursor-pointer transition-colors group flex items-start gap-4 {{ $doctor_profile_id === $doc->id ? 'border-[#18181B] dark:border-white bg-[#FAFAFA] dark:bg-[#1F2937]' : 'border-[#E4E4E7] dark:border-[#1F2937] bg-white dark:bg-[#111827]' }}">
                            <div class="w-12 h-12 rounded-lg bg-[#F4F4F5] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#374151] flex items-center justify-center shrink-0 text-[#18181B] dark:text-white font-semibold text-lg"
                                 style="font-family:'Geist',sans-serif;">
                                {{ substr($doc->user->name, 4, 1) ?: substr($doc->user->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:0.9375rem;" class="text-[#18181B] dark:text-white">{{ $doc->user->name }}</h3>
                                <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;" class="text-[#71717A] dark:text-gray-400 mt-0.5">{{ $doc->specialization }}</p>
                                <div class="mt-3 flex items-center gap-3 text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                                    <span>{{ $doc->years_experience }} yrs exp.</span>
                                    <span>•</span>
                                    <span class="font-medium text-[#18181B] dark:text-white">${{ number_format($doc->consultation_fee, 2) }}</span>
                                </div>
                            </div>
                            <svg class="shrink-0 text-[#18181B] dark:text-white opacity-0 group-hover:opacity-100 transition-opacity" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- STEP 3: Select Date & Time Slot -->
    @if($step === 3)
        <div class="reveal in-view">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <span class="section-eyebrow">{{ $selectedDoctor->user->name ?? 'Doctor' }} · {{ $selectedDept->name ?? '' }}</span>
                    <h2 class="section-heading" style="font-size: 1.75rem;">Select Date & Time</h2>
                </div>
                <button wire:click="goToStep(2)" class="btn-outline-sm">Change Doctor</button>
            </div>

            <!-- Date Picker strip -->
            <div class="mb-8">
                <label class="form-label mb-3">Available Dates (Next 14 Days)</label>
                <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                    @forelse($this->availableDates as $d)
                        <button type="button"
                                wire:key="date-{{ $d['formatted'] }}"
                                wire:click="selectDate('{{ $d['formatted'] }}')"
                                class="flex flex-col items-center justify-center px-4 py-3 border rounded-xl min-w-[72px] transition-all {{ $appointment_date === $d['formatted'] ? 'bg-[#18181B] dark:bg-white border-[#18181B] dark:border-white text-white dark:text-[#18181B] ring-2 ring-offset-1 ring-[#18181B]' : 'bg-white dark:bg-[#111827] border-[#E4E4E7] dark:border-[#1F2937] text-[#18181B] dark:text-white hover:bg-gray-50 dark:hover:bg-[#1F2937]' }}"
                                style="font-family:'Geist',sans-serif;">
                            <span class="text-[10px] uppercase font-medium tracking-wider opacity-70">{{ $d['day_name'] }}</span>
                            <span class="text-lg font-bold leading-tight">{{ $d['day_num'] }}</span>
                            <span class="text-[10px] opacity-70">{{ $d['month'] }}</span>
                        </button>
                    @empty
                        <p class="text-sm text-[#71717A] dark:text-gray-400 py-3" style="font-family:'Geist',sans-serif;">No available work schedules for this doctor in the next 14 days.</p>
                    @endforelse
                </div>
            </div>

            <!-- Time Slots -->
            @if($appointment_date)
                <div class="mb-8">
                    <label class="form-label mb-3">Available Time Slots for {{ \Carbon\Carbon::parse($appointment_date)->format('M j, Y') }}</label>
                    @if(empty($this->availableSlots))
                        <p class="text-sm text-[#71717A] dark:text-gray-400 py-3" style="font-family:'Geist',sans-serif;">All time slots for this date are booked or past. Please choose another date.</p>
                    @else
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                            @foreach($this->availableSlots as $slot)
                                <button type="button"
                                        wire:key="slot-{{ $slot['raw'] }}"
                                        wire:click="selectTime('{{ $slot['raw'] }}')"
                                        class="py-2.5 px-3 border rounded-lg text-xs font-medium transition-all text-center {{ $appointment_time === $slot['raw'] ? 'bg-[#18181B] dark:bg-white border-[#18181B] dark:border-white text-white dark:text-[#18181B] ring-2 ring-offset-1 ring-[#18181B]' : 'bg-white dark:bg-[#111827] border-[#E4E4E7] dark:border-[#1F2937] text-[#18181B] dark:text-white hover:bg-gray-50 dark:hover:bg-[#1F2937]' }}"
                                        style="font-family:'Geist',sans-serif;">
                                    {{ $slot['display'] }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                    @error('appointment_time') <p class="form-error mt-2">{{ $message }}</p> @enderror
                </div>
            @endif

            <div class="flex justify-end pt-4 border-t border-[#E4E4E7] dark:border-[#1F2937]">
                <button type="button"
                        wire:click="nextStep"
                        @if(!$appointment_date || !$appointment_time) disabled @endif
                        class="btn-primary"
                        style="opacity: {{ ($appointment_date && $appointment_time) ? '1' : '0.5' }};">
                    Continue to Details
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- STEP 4: Patient Info & Confirmation -->
    @if($step === 4)
        <div class="reveal in-view">
            <h2 class="section-heading mb-6" style="font-size: 1.75rem;">Confirm Appointment</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Left: Booking Summary Card -->
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl p-5 space-y-4 shadow-sm">
                        <span class="text-[10px] uppercase tracking-wider font-semibold text-[#71717A] dark:text-gray-400">Summary</span>

                        <div>
                            <p class="text-xs text-[#71717A] dark:text-gray-400">Department</p>
                            <p class="text-sm font-semibold text-[#18181B] dark:text-white">{{ $selectedDept->name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#71717A] dark:text-gray-400">Doctor</p>
                            <p class="text-sm font-semibold text-[#18181B] dark:text-white">{{ $selectedDoctor->user->name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#71717A] dark:text-gray-400">Date & Time</p>
                            <p class="text-sm font-semibold text-[#18181B] dark:text-white">
                                {{ \Carbon\Carbon::parse($appointment_date)->format('l, M j, Y') }}
                                <br>
                                {{ \Carbon\Carbon::parse($appointment_time)->format('g:i A') }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-[#E4E4E7] dark:border-[#1F2937] flex justify-between items-center">
                            <span class="text-xs text-[#71717A] dark:text-gray-400">Fee</span>
                            <span class="text-base font-bold text-[#18181B] dark:text-white">${{ number_format($selectedDoctor->consultation_fee ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Patient Form -->
                <div class="md:col-span-2 space-y-5">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" wire:model="patient_name" class="form-input" placeholder="Your full name" required>
                        @error('patient_name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Email Address</label>
                            <input type="email" wire:model="patient_email" class="form-input" placeholder="your.email@example.com" required>
                            @error('patient_email') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Phone Number</label>
                            <input type="text" wire:model="patient_phone" class="form-input" placeholder="+1 (555) 000-0000">
                            @error('patient_phone') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Reason for Visit / Symptoms (Optional)</label>
                        <textarea wire:model="reason" rows="4" class="form-input resize-none" placeholder="Briefly describe your symptoms or reason for consultation..."></textarea>
                        @error('reason') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-between border-t border-[#E4E4E7] dark:border-[#1F2937]">
                        <button type="button" wire:click="goToStep(3)" class="btn-outline-sm">Back</button>
                        <button type="button" wire:click="submitBooking" class="btn-primary" style="padding:0.75rem 1.75rem;">
                            Confirm Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
