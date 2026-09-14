<x-app-layout>
    <x-slot name="title">Departments</x-slot>

    <!-- Header Hero: Vantablack Atmosphere with Ambient Orbs -->
    <section class="relative bg-[#09090B] text-white py-24 overflow-hidden border-b border-[#27272A]">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-emerald-600/10 blur-3xl pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center">
            <span class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A1A1AA] bg-white/5 border border-white/10 px-3 py-1 rounded-full mb-4">
                Clinical Excellence
            </span>
            <h1 style="font-family:'Instrument Serif',serif;font-size:clamp(2.75rem,6vw,4.5rem);line-height:1.05;letter-spacing:-0.03em;color:#F4F4F5;">
                Medical Departments
            </h1>
            <p class="mt-4 text-base text-[#A1A1AA] max-w-xl mx-auto leading-relaxed" style="font-family:'Geist',sans-serif;">
                Explore our 10 specialized clinical divisions led by board-certified consultants and surgical teams.
            </p>
        </div>
    </section>

    <!-- Departments Grid Section -->
    <section class="py-20 bg-[var(--canvas)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

            <div class="flex items-center justify-between mb-10 pb-4 border-b border-[#E4E4E7] dark:border-[#1F2937]">
                <span class="text-xs font-semibold text-[#71717A] dark:text-gray-400 uppercase tracking-wider" style="font-family:'Geist',sans-serif;">
                    Active Specialty Units ({{ $departments->count() }})
                </span>
                <a href="{{ route('doctors.index') }}" class="btn-outline-sm">
                    Browse All Doctors →
                </a>
            </div>

            <!-- Bento Box Grid with kinetic hover physics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($departments as $i => $dept)
                <a href="{{ route('departments.show', $dept->slug) }}"
                   class="reveal reveal-delay-{{ min($i+1, 5) }} kinetic-card p-7 flex flex-col justify-between group bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937]"
                   style="text-decoration:none;min-height:220px;">
                    <div>
                        <!-- Department Icon Badge -->
                        <div class="w-11 h-11 rounded-xl bg-[#F4F4F5] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#374151] flex items-center justify-center mb-5 group-hover:bg-[#18181B] dark:group-hover:bg-white group-hover:border-[#18181B] dark:group-hover:border-white transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="text-[#18181B] dark:text-white group-hover:text-white dark:group-hover:text-[#18181B] transition-colors">
                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Geist',sans-serif;font-weight:600;font-size:1.125rem;letter-spacing:-0.02em;" class="text-[#18181B] dark:text-white">
                            {{ $dept->name }}
                        </h2>
                        <p style="font-family:'Geist',sans-serif;font-size:0.875rem;margin-top:0.5rem;line-height:1.6;" class="text-[#71717A] dark:text-gray-400">
                            {{ Str::limit($dept->description, 90) }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-[#E4E4E7] dark:border-[#1F2937] flex items-center justify-between">
                        <span class="text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                            Specialist Unit
                        </span>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#18181B] dark:text-white group-hover:translate-x-1 transition-transform">
                            View Department
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </section>

</x-app-layout>
