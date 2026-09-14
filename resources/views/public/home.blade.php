<x-app-layout>
<x-slot name="title">Home</x-slot>

{{-- ── Hero — Left-aligned asymmetric split ─────────────────────── --}}
<section class="min-h-[100dvh] flex items-center bg-[var(--canvas)]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 w-full py-24 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

        <!-- Left: text block -->
        <div class="reveal">
            <span class="section-eyebrow">Specialist Healthcare</span>
            <h1 class="section-heading" style="font-size:clamp(2.5rem,5vw,3.75rem);">
                Care that starts<br>
                <em style="font-style:italic;" class="text-[#71717A] dark:text-gray-400">with you.</em>
            </h1>
            <p class="section-subheading">
                Refer, book, and track appointments across {{ $stats['departments'] }} departments and {{ $stats['doctors'] }} consultants. No waiting room guesswork.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ auth()->check() ? route('patient.appointments.create') : route('register') }}"
                   class="btn-primary" style="padding:0.75rem 1.5rem;font-size:0.9375rem;">
                    Book Appointment
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('doctors.index') }}" class="btn-outline" style="padding:0.75rem 1.5rem;font-size:0.9375rem;">
                    Meet Our Doctors
                </a>
            </div>

            <!-- Stats strip -->
            <div class="mt-12 flex gap-8">
                <div>
                    <p style="font-family:'Geist',sans-serif;font-size:1.5rem;font-weight:700;letter-spacing:-0.03em;" class="text-[#18181B] dark:text-white">
                        {{ $stats['doctors'] > 50 ? '50+' : $stats['doctors'] }}
                    </p>
                    <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;margin-top:0.125rem;" class="text-[#71717A] dark:text-gray-400">Consultants</p>
                </div>
                <div>
                    <p style="font-family:'Geist',sans-serif;font-size:1.5rem;font-weight:700;letter-spacing:-0.03em;" class="text-[#18181B] dark:text-white">
                        {{ $stats['departments'] }}
                    </p>
                    <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;margin-top:0.125rem;" class="text-[#71717A] dark:text-gray-400">Departments</p>
                </div>
                <div>
                    <p style="font-family:'Geist',sans-serif;font-size:1.5rem;font-weight:700;letter-spacing:-0.03em;" class="text-[#18181B] dark:text-white">
                        {{ $stats['patients'] >= 1000 ? number_format($stats['patients'] / 1000, 1) . 'k+' : $stats['patients'] }}
                    </p>
                    <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;margin-top:0.125rem;" class="text-[#71717A] dark:text-gray-400">Patients</p>
                </div>
            </div>
        </div>

        <!-- Right: department quick-access card -->
        <div class="reveal reveal-delay-2">
            <div class="hms-card p-0 overflow-hidden bg-white dark:bg-[#111827]">
                <div class="px-5 py-4 border-b border-[#E4E4E7] dark:border-[#1F2937] flex items-center justify-between">
                    <span style="font-family:'Geist',sans-serif;font-size:0.8125rem;font-weight:500;" class="text-[#18181B] dark:text-white">Quick Booking</span>
                    <span style="font-family:'Geist',sans-serif;font-size:0.75rem;" class="text-[#71717A] dark:text-gray-400">Available today</span>
                </div>
                <div class="divide-y divide-[#E4E4E7] dark:divide-[#1F2937]">
                    @foreach($departments->take(5) as $dept)
                    <a href="{{ route('departments.show', $dept->slug) }}"
                       class="flex items-center justify-between px-5 py-3.5 hover:bg-[#FAFAFA] dark:hover:bg-[#1F2937]/50 transition-colors group"
                       style="text-decoration:none;">
                        <span style="font-family:'Geist',sans-serif;font-size:0.875rem;" class="text-[#18181B] dark:text-white">{{ $dept->name }}</span>
                        <svg class="group-hover:translate-x-0.5 transition-transform text-[#A1A1AA] dark:text-gray-400" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    @endforeach
                </div>
                <div class="px-5 py-4 border-t border-[#E4E4E7] dark:border-[#1F2937]">
                    <a href="{{ route('departments.index') }}" class="btn-primary w-full justify-center">
                        View All Departments
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Section divider ─────────────────────────────────────────── --}}
<hr class="hms-divider max-w-5xl mx-auto border-[#E4E4E7] dark:border-[#1F2937]">

{{-- ── Departments — Bento grid ────────────────────────────────── --}}
<section class="py-24 bg-[var(--canvas)]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="reveal mb-12">
            <span class="section-eyebrow">Our Expertise</span>
            <h2 class="section-heading">Medical Departments</h2>
            <p class="section-subheading">Specialist care across every medical field.</p>
        </div>

        <!-- Asymmetric bento grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-[#E4E4E7] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl overflow-hidden">
            @forelse($departments as $i => $dept)
            <a href="{{ route('departments.show', $dept->slug) }}"
               class="reveal reveal-delay-{{ min($i+1,5) }} bg-white dark:bg-[#111827] p-7 flex flex-col gap-4 hover:bg-[#FAFAFA] dark:hover:bg-[#1F2937]/50 transition-colors group"
               style="text-decoration:none;min-height:160px;">
                <!-- Icon -->
                <div class="w-9 h-9 rounded-lg bg-[#F4F4F5] dark:bg-[#1F2937] flex items-center justify-center group-hover:bg-[#E4E4E7] dark:group-hover:bg-[#374151] transition-colors">
                    @php
                        $icons = [
                            'cardiology'       => '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>',
                            'neurology'        => '<path d="M9.5 2A2.5 2.5 0 0112 4.5v15a2.5 2.5 0 01-4.96-.46 2.5 2.5 0 01-1.07-4.8A2.5 2.5 0 014.5 12a2.5 2.5 0 012.5-2.5h.5m6-3a2.5 2.5 0 01-2.5 2.5H11m1-2.5A2.5 2.5 0 0114.5 12a2.5 2.5 0 01-1.93 2.44A2.5 2.5 0 0119.04 19a2.5 2.5 0 01-4.96-.46"/>',
                            'orthopedics'      => '<path d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8z"/><circle cx="14" cy="4" r="2"/>',
                            'pediatrics'       => '<path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9a12.02 12.02 0 00-.382-3.016z"/>',
                            'dermatology'      => '<circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/>',
                            'ophthalmology'    => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
                            'gynecology'       => '<circle cx="12" cy="8" r="4"/><path d="M12 12v9m-4-4h8"/>',
                            'general-surgery'  => '<path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>',
                            'internal-medicine'=> '<path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
                            'emergency-medicine'=>'<path d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                        ];
                        $iconPath = $icons[$dept->slug] ?? '<path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                    @endphp
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#18181B] dark:text-white" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        {!! $iconPath !!}
                    </svg>
                </div>
                <div>
                    <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:0.9375rem;margin-bottom:0.25rem;" class="text-[#18181B] dark:text-white">{{ $dept->name }}</h3>
                    <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;line-height:1.5;" class="text-[#71717A] dark:text-gray-400">{{ Str::limit($dept->description, 60) }}</p>
                </div>
                <div class="mt-auto flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity text-[#18181B] dark:text-white font-medium text-xs" style="font-family:'Geist',sans-serif;">
                    View
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="group-hover:translate-x-0.5 transition-transform"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center py-16 text-[#71717A] dark:text-gray-400 bg-white dark:bg-[#111827]" style="font-family:'Geist',sans-serif;font-size:0.875rem;">No departments yet.</div>
            @endforelse
        </div>
    </div>
</section>

<hr class="hms-divider max-w-5xl mx-auto border-[#E4E4E7] dark:border-[#1F2937]">

{{-- ── Doctors section ─────────────────────────────────────────── --}}
<section class="py-24 bg-[var(--canvas)]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="reveal flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
            <div>
                <span class="section-eyebrow">Meet The Team</span>
                <h2 class="section-heading">Our Consultants</h2>
            </div>
            <a href="{{ route('doctors.index') }}" class="btn-outline shrink-0">
                View All Doctors
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($doctors as $i => $doctor)
            <a href="{{ route('doctors.show', $doctor->id) }}"
               class="reveal reveal-delay-{{ min($i+1,5) }} hms-card p-5 flex items-center gap-4 hover:bg-[#FAFAFA] dark:hover:bg-[#1F2937]/50 transition-colors group bg-white dark:bg-[#111827] border-[#E4E4E7] dark:border-[#1F2937]"
               style="text-decoration:none;">
                <!-- Avatar -->
                <div class="w-11 h-11 rounded-lg bg-[#F4F4F5] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#374151] flex items-center justify-center shrink-0 font-semibold text-base text-[#18181B] dark:text-white" style="font-family:'Geist',sans-serif;">
                    {{ substr($doctor->user->name, 4, 1) ?: substr($doctor->user->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p style="font-family:'Geist',sans-serif;font-weight:600;font-size:0.9375rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" class="text-[#18181B] dark:text-white">{{ $doctor->user->name }}</p>
                    <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;margin-top:0.125rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" class="text-[#71717A] dark:text-gray-400">{{ $doctor->specialization }}</p>
                </div>
                <svg class="shrink-0 opacity-30 group-hover:opacity-80 group-hover:translate-x-0.5 transition-all text-[#18181B] dark:text-white" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            @empty
            <p class="col-span-3 text-center py-12 text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">No doctors yet.</p>
            @endforelse
        </div>
    </div>
</section>

<hr class="hms-divider max-w-5xl mx-auto border-[#E4E4E7] dark:border-[#1F2937]">

{{-- ── Why section — horizontal rule dividers, no cards ───────── --}}
<section class="py-24 bg-[var(--canvas)]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="reveal mb-12">
            <span class="section-eyebrow">Why MedCare</span>
            <h2 class="section-heading">Built around the patient.</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-[#E4E4E7] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl overflow-hidden">
            @foreach([
                ['Round-the-clock emergency', 'Our emergency department operates 24 hours a day, 365 days a year — no appointment required.'],
                ['Modern diagnostics', 'In-house labs, imaging, and pathology under one roof. Results delivered the same day where possible.'],
                ['Coordinated specialist care', 'A single patient record follows you across every department. No repeated forms, no lost history.'],
                ['Transparent billing', 'Every invoice itemised before you leave. No surprise charges after the fact.'],
            ] as [$title, $desc])
            <div class="reveal bg-white dark:bg-[#111827] p-8">
                <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:1rem;margin-bottom:0.5rem;" class="text-[#18181B] dark:text-white">{{ $title }}</h3>
                <p style="font-family:'Geist',sans-serif;font-size:0.875rem;line-height:1.65;" class="text-[#71717A] dark:text-gray-400">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<hr class="hms-divider max-w-5xl mx-auto border-[#E4E4E7] dark:border-[#1F2937]">

{{-- ── CTA Strip ────────────────────────────────────────────────── --}}
<section class="py-20 bg-[var(--canvas)]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 reveal flex flex-col sm:flex-row items-start sm:items-center justify-between gap-8 border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl bg-white dark:bg-[#111827] p-10 shadow-sm">
        <div>
            <h2 style="font-family:'Instrument Serif',serif;font-size:clamp(1.5rem,3vw,2rem);letter-spacing:-0.025em;line-height:1.15;" class="text-[#18181B] dark:text-white">Ready when you are.</h2>
            <p style="font-family:'Geist',sans-serif;font-size:0.9375rem;margin-top:0.5rem;" class="text-[#71717A] dark:text-gray-400">Booking takes under two minutes. Pick a department, choose a doctor, select a slot.</p>
        </div>
        <div class="flex gap-3 shrink-0">
            <a href="{{ auth()->check() ? route('patient.appointments.create') : route('register') }}" class="btn-primary" style="padding:0.75rem 1.5rem;">
                Book Appointment
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('contact') }}" class="btn-outline" style="padding:0.75rem 1.5rem;">Contact</a>
        </div>
    </div>
</section>

</x-app-layout>
