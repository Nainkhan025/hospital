<x-app-layout>
    <x-slot name="title">{{ $doctor->user->name }}</x-slot>

    <!-- Header Hero: Dark Vantablack Atmosphere -->
    <section class="relative bg-[#09090B] text-white py-20 overflow-hidden border-b border-[#27272A]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10">
            <a href="{{ route('doctors.index') }}" class="inline-flex items-center gap-1 text-xs text-[#A1A1AA] hover:text-white mb-6 transition-colors font-medium">
                ← All Doctors
            </a>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="w-24 h-24 rounded-2xl bg-white text-[#09090B] flex items-center justify-center text-3xl font-bold font-outfit shadow-2xl shrink-0">
                    {{ substr($doctor->user->name, 4, 1) ?: substr($doctor->user->name, 0, 1) }}
                </div>
                <div>
                    <span class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A1A1AA] bg-white/5 border border-white/10 px-3 py-1 rounded-full mb-2">
                        {{ $doctor->department->name ?? 'Specialist Unit' }}
                    </span>
                    <h1 style="font-family:'Instrument Serif',serif;font-size:clamp(2.5rem,5vw,3.75rem);line-height:1.05;color:#F4F4F5;">
                        {{ $doctor->user->name }}
                    </h1>
                    <p class="text-sm text-[#A1A1AA] font-medium mt-1">{{ $doctor->specialization }} · {{ $doctor->qualifications }}</p>

                    <div class="mt-4 flex flex-wrap gap-2 text-xs">
                        <span class="bg-white/10 border border-white/15 px-3 py-1 rounded-md text-white font-medium">
                            🏆 {{ $doctor->years_experience }} Years Clinical Experience
                        </span>
                        <span class="bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 px-3 py-1 rounded-md font-medium">
                            ✓ Accepting Patients
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Profile Content Grid -->
    <section class="py-16 bg-[var(--canvas)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Biography & Weekly Schedule -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Biography Card -->
                <div class="bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl p-6 shadow-sm">
                    <h2 style="font-family:'Instrument Serif',serif;font-size:1.75rem;" class="text-[#18181B] dark:text-white mb-3">
                        About {{ $doctor->user->name }}
                    </h2>
                    <p class="text-sm text-[#71717A] dark:text-gray-400 leading-relaxed" style="font-family:'Geist',sans-serif;">
                        {{ $doctor->bio ?? 'Senior consultant committed to delivering patient-centered medical care with a focus on diagnostic accuracy and personalized treatment plans.' }}
                    </p>
                </div>

                <!-- Weekly Work Schedule Card -->
                <div class="bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl p-6 shadow-sm">
                    <h2 style="font-family:'Instrument Serif',serif;font-size:1.75rem;" class="text-[#18181B] dark:text-white mb-4">
                        Weekly Clinical Schedule
                    </h2>

                    @php $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; @endphp
                    @if($doctor->schedules->isEmpty())
                        <p class="text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">No work schedule logged.</p>
                    @else
                        <div class="divide-y divide-[#E4E4E7] dark:divide-[#1F2937]">
                            @foreach($doctor->schedules->where('specific_date', null)->sortBy('day_of_week') as $sch)
                            <div class="py-3 flex items-center justify-between text-xs" style="font-family:'Geist',sans-serif;">
                                <span class="font-medium text-[#18181B] dark:text-white w-28">{{ $days[$sch->day_of_week] ?? '' }}</span>
                                @if($sch->is_available)
                                    <span class="text-[#71717A] dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($sch->start_time)->format('g:i A') }} –
                                        {{ \Carbon\Carbon::parse($sch->end_time)->format('g:i A') }}
                                    </span>
                                    <span class="badge badge-completed">Available</span>
                                @else
                                    <span class="badge badge-cancelled">Unavailable</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right: Sticky Booking Drawer Card -->
            <div>
                <div class="bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl p-6 sticky top-24 shadow-sm">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#A1A1AA] dark:text-gray-400 block mb-2">Book Consultation</span>
                    
                    <div class="space-y-3 text-xs text-[#71717A] dark:text-gray-400 mb-6" style="font-family:'Geist',sans-serif;">
                        <div class="flex justify-between py-2 border-b border-[#E4E4E7] dark:border-[#1F2937]">
                            <span>Department</span>
                            <span class="font-semibold text-[#18181B] dark:text-white">{{ $doctor->department->name ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-[#E4E4E7] dark:border-[#1F2937]">
                            <span>Consultation Fee</span>
                            <span class="font-bold text-base text-[#18181B] dark:text-white">${{ number_format($doctor->consultation_fee, 2) }}</span>
                        </div>
                    </div>

                    <a href="{{ auth()->check() ? route('patient.appointments.create', ['selectedDoctor' => $doctor->id]) : route('register') }}"
                       class="btn-primary w-full justify-center text-sm py-3 font-medium shadow-sm hover:shadow transition-all" style="border-radius:8px;">
                        Select Date & Time Slot
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>

                    @guest
                    <p class="mt-4 text-[11px] text-[#A1A1AA] dark:text-gray-400 text-center" style="font-family:'Geist',sans-serif;">
                        New patient? <a href="{{ route('register') }}" class="text-[#18181B] dark:text-white font-semibold underline">Register to book</a>
                    </p>
                    @endguest
                </div>
            </div>

        </div>
    </section>
</x-app-layout>
