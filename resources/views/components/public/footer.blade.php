<footer class="relative bg-[#09090B] text-white border-t border-[#27272A] overflow-hidden" style="font-family:'Geist',sans-serif;">
    
    <!-- Ambient Light Orbs -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-emerald-600/10 blur-3xl pointer-events-none"></div>

    <!-- Editorial Header Callout Strip -->
    <div class="border-b border-[#27272A] relative z-10 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A1A1AA] bg-white/5 border border-white/10 px-3 py-1 rounded-full mb-3">
                    24/7 Specialist Healthcare
                </span>
                <h2 style="font-family:'Instrument Serif',serif;font-size:clamp(2rem,4vw,3.25rem);line-height:1.05;color:#F4F4F5;" class="tracking-tight">
                    Specialist care, <em class="italic text-slate-400">every single day.</em>
                </h2>
            </div>
            <div class="shrink-0 flex items-center gap-3">
                <a href="{{ auth()->check() ? route('patient.appointments.create') : route('register') }}"
                   class="inline-flex items-center gap-2 bg-white text-[#09090B] hover:bg-[#F4F4F5] text-xs font-semibold px-5 py-3 rounded-lg transition-transform hover:-translate-y-0.5" style="text-decoration:none;">
                    Book Consultation
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Footer Links Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16 grid grid-cols-1 md:grid-cols-12 gap-10 relative z-10">

        <!-- Col 1: Brand & Emergency Hotline (4 Cols) -->
        <div class="md:col-span-4 space-y-5">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#09090B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 21.7C17.3 17 22 13 22 8.5a6.5 6.5 0 00-13 0C9 13 13.7 17 12 21.7z"/>
                        <circle cx="12" cy="8.5" r="2.5"/>
                    </svg>
                </div>
                <span class="font-bold text-xl text-white tracking-tight">MedCare</span>
            </a>

            <p class="text-xs text-[#A1A1AA] leading-relaxed max-w-sm">
                Leading multi-specialty hospital committed to clinical precision, evidence-based care, and patient comfort.
            </p>

            <!-- Emergency Card Badge -->
            <div class="p-4 rounded-xl bg-white/5 border border-white/10 max-w-sm">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-rose-400">Emergency Line</span>
                    <span class="inline-flex items-center gap-1 text-[10px] text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> 24/7 Desk
                    </span>
                </div>
                <p class="text-base font-bold text-white font-mono tracking-tight">+1 (800) 911-0000</p>
            </div>
        </div>

        <!-- Col 2: Quick Links (3 Cols) -->
        <div class="md:col-span-3 space-y-3">
            <h3 class="text-xs font-bold uppercase tracking-widest text-white">Navigation</h3>
            <ul class="space-y-2 text-xs text-[#A1A1AA]">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors inline-flex items-center gap-1 group">
                        <span class="group-hover:translate-x-1 transition-transform">Home Overview</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('departments.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1 group">
                        <span class="group-hover:translate-x-1 transition-transform">Specialty Departments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('doctors.index') }}" class="hover:text-white transition-colors inline-flex items-center gap-1 group">
                        <span class="group-hover:translate-x-1 transition-transform">Our Doctors Directory</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="hover:text-white transition-colors inline-flex items-center gap-1 group">
                        <span class="group-hover:translate-x-1 transition-transform">Contact & Location</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Col 3: Clinical Services (3 Cols) -->
        <div class="md:col-span-3 space-y-3">
            <h3 class="text-xs font-bold uppercase tracking-widest text-white">Specialties</h3>
            <ul class="space-y-2 text-xs text-[#A1A1AA]">
                <li class="hover:text-white transition-colors cursor-default">Cardiology & Vascular</li>
                <li class="hover:text-white transition-colors cursor-default">Neurology & Neurosurgery</li>
                <li class="hover:text-white transition-colors cursor-default">Orthopedics & Sports Medicine</li>
                <li class="hover:text-white transition-colors cursor-default">Pediatrics & Neonatology</li>
                <li class="hover:text-white transition-colors cursor-default">Emergency & Trauma Surgery</li>
            </ul>
        </div>

        <!-- Col 4: Address & Portal (2 Cols) -->
        <div class="md:col-span-2 space-y-3">
            <h3 class="text-xs font-bold uppercase tracking-widest text-white">Location</h3>
            <p class="text-xs text-[#A1A1AA] leading-relaxed">
                123 Medical Drive<br>
                Health City Campus<br>
                New York, NY 10001
            </p>
            <div class="pt-2">
                <a href="{{ route('login') }}" class="text-xs font-medium text-slate-300 hover:text-white underline">
                    Staff & Patient Login →
                </a>
            </div>
        </div>

    </div>

    <!-- Bottom Legal Bar -->
    <div class="border-t border-[#27272A] py-6 relative z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#71717A]">
            <p>© {{ date('Y') }} MedCare Hospital. HIPAA Compliant Systems.</p>
            <div class="flex items-center gap-6">
                <span>Terms of Service</span>
                <span>Privacy Notice</span>
                <span class="inline-flex items-center gap-1.5 text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span> All Systems Operational
                </span>
            </div>
        </div>
    </div>

</footer>
