<x-app-layout>
    <x-slot name="title">{{ $department->name }} Department</x-slot>

    <!-- Header Hero -->
    <section class="relative bg-[#09090B] text-white py-20 overflow-hidden border-b border-[#27272A]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10">
            <a href="{{ route('departments.index') }}" class="inline-flex items-center gap-1 text-xs text-[#A1A1AA] hover:text-white mb-6 transition-colors font-medium">
                ← All Departments
            </a>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A1A1AA] bg-white/5 border border-white/10 px-3 py-1 rounded-full mb-3">
                        Clinical Specialty
                    </span>
                    <h1 style="font-family:'Instrument Serif',serif;font-size:clamp(2.5rem,5vw,4rem);line-height:1.05;letter-spacing:-0.03em;color:#F4F4F5;">
                        {{ $department->name }}
                    </h1>
                    <p class="mt-3 text-sm text-[#A1A1AA] max-w-2xl leading-relaxed" style="font-family:'Geist',sans-serif;">
                        {{ $department->description }}
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ auth()->check() ? route('patient.appointments.create', ['selectedDepartment' => $department->id]) : route('register') }}"
                       class="btn-primary" style="padding:0.75rem 1.5rem;">
                        Book Consultation
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Consultants in Department -->
    <section class="py-20 bg-[var(--canvas)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-[#E4E4E7] dark:border-[#1F2937]">
                <h2 style="font-family:'Instrument Serif',serif;font-size:2rem;" class="text-[#18181B] dark:text-white">
                    Consultants in {{ $department->name }}
                </h2>
                <span class="text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                    {{ $department->doctorProfiles->count() }} Doctors Available
                </span>
            </div>

            @if($department->doctorProfiles->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                    No doctors currently listed in this department.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($department->doctorProfiles as $i => $doc)
                    <div class="reveal reveal-delay-{{ min($i+1, 5) }} kinetic-card p-6 flex flex-col justify-between bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937]">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-xl bg-[#F4F4F5] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#374151] flex items-center justify-center font-bold text-lg text-[#18181B] dark:text-white shrink-0" style="font-family:'Geist',sans-serif;">
                                    {{ substr($doc->user->name, 4, 1) ?: substr($doc->user->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:1rem;" class="text-[#18181B] dark:text-white truncate">
                                        {{ $doc->user->name }}
                                    </h3>
                                    <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;" class="text-[#71717A] dark:text-gray-400 truncate">
                                        {{ $doc->specialization }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-xs text-[#71717A] dark:text-gray-400 leading-relaxed line-clamp-3" style="font-family:'Geist',sans-serif;">
                                {{ $doc->bio ?? 'Senior consultant specializing in advanced clinical care.' }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#E4E4E7] dark:border-[#1F2937] flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-[#A1A1AA] dark:text-gray-400 uppercase font-bold tracking-wider block">Fee</span>
                                <span class="text-sm font-bold text-[#18181B] dark:text-white">${{ number_format($doc->consultation_fee, 2) }}</span>
                            </div>
                            <a href="{{ route('doctors.show', $doc->id) }}" class="btn-outline-sm py-1.5 px-3">
                                View Profile
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
