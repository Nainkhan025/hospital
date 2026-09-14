<x-app-layout>
    <x-slot name="title">Our Doctors</x-slot>

    <!-- Header Hero: Vantablack Atmosphere with Ambient Orbs -->
    <section class="relative bg-[#09090B] text-white py-24 overflow-hidden border-b border-[#27272A]">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-emerald-600/10 blur-3xl pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center">
            <span class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A1A1AA] bg-white/5 border border-white/10 px-3 py-1 rounded-full mb-4">
                Medical Staff Directory
            </span>
            <h1 style="font-family:'Instrument Serif',serif;font-size:clamp(2.75rem,6vw,4.5rem);line-height:1.05;letter-spacing:-0.03em;color:#F4F4F5;">
                Meet Our Consultants
            </h1>
            <p class="mt-4 text-base text-[#A1A1AA] max-w-xl mx-auto leading-relaxed" style="font-family:'Geist',sans-serif;">
                Board-certified specialists committed to providing evidence-based compassionate clinical care.
            </p>
        </div>
    </section>

    <!-- Filter Control Bar -->
    <section class="bg-white dark:bg-[#111827] border-b border-[#E4E4E7] dark:border-[#1F2937] py-5 relative z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <form method="GET" action="{{ route('doctors.index') }}" class="flex flex-wrap gap-3 items-center justify-between">
                <div class="flex flex-wrap gap-3 items-center flex-1">
                    <!-- Search Input -->
                    <div class="relative min-w-[240px] flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search doctor by name or specialty..."
                               class="form-input text-sm py-2.5 px-4" />
                    </div>

                    <!-- Department Dropdown -->
                    <select name="department" class="form-select text-sm py-2.5 max-w-xs">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-primary" style="padding:0.625rem 1.25rem;">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'department']))
                        <a href="{{ route('doctors.index') }}" class="btn-outline-sm py-2 px-3">Clear Filters</a>
                    @endif
                </div>

                <span class="text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                    Showing {{ $doctors->total() }} Doctors
                </span>
            </form>
        </div>
    </section>

    <!-- Doctors Grid Section -->
    <section class="py-20 bg-[var(--canvas)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            @if($doctors->isEmpty())
                <div class="text-center py-20 bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                    No doctors found matching your criteria. Try resetting your search filters.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($doctors as $i => $doctor)
                    <div class="reveal reveal-delay-{{ min($i+1, 5) }} kinetic-card p-6 flex flex-col justify-between group bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937]">
                        <div>
                            <!-- Header Avatar -->
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-14 h-14 rounded-xl bg-[#09090B] dark:bg-white text-white dark:text-[#09090B] flex items-center justify-center font-bold text-xl shrink-0" style="font-family:'Geist',sans-serif;">
                                    {{ substr($doctor->user->name, 4, 1) ?: substr($doctor->user->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h2 style="font-family:'Geist',sans-serif;font-weight:600;font-size:1.0625rem;" class="text-[#18181B] dark:text-white truncate">
                                        {{ $doctor->user->name }}
                                    </h2>
                                    <p style="font-family:'Geist',sans-serif;font-size:0.8125rem;font-weight:500;" class="text-[#1F6C9F] dark:text-[#60A5FA] truncate">
                                        {{ $doctor->specialization }}
                                    </p>
                                    <span class="inline-block text-[11px] text-[#71717A] dark:text-gray-400 mt-0.5">
                                        {{ $doctor->department->name ?? 'Specialist Unit' }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-2 text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                                <div class="flex items-center justify-between py-1 border-t border-[#E4E4E7] dark:border-[#1F2937]">
                                    <span>Qualifications</span>
                                    <span class="font-medium text-[#18181B] dark:text-white">{{ $doctor->qualifications }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1 border-t border-[#E4E4E7] dark:border-[#1F2937]">
                                    <span>Experience</span>
                                    <span class="font-medium text-[#18181B] dark:text-white">{{ $doctor->years_experience }} Years</span>
                                </div>
                                <div class="flex items-center justify-between py-1 border-t border-[#E4E4E7] dark:border-[#1F2937]">
                                    <span>Consultation Fee</span>
                                    <span class="font-bold text-[#18181B] dark:text-white">${{ number_format($doctor->consultation_fee, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#E4E4E7] dark:border-[#1F2937] flex items-center gap-2">
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn-outline flex-1 justify-center text-xs py-2">
                                Full Profile
                            </a>
                            <a href="{{ auth()->check() ? route('patient.appointments.create', ['selectedDoctor' => $doctor->id]) : route('register') }}"
                               class="btn-primary flex-1 justify-center text-xs py-2">
                                Book
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $doctors->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
