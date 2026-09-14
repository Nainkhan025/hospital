<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Authentication' }} — MedCare Hospital</title>

    <!-- Fonts: Geist + Instrument Serif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="h-full antialiased text-[#18181B] dark:text-[#F9FAFB] selection:bg-[#18181B] selection:text-white bg-[#F9FAFB] dark:bg-[#090D16] transition-colors duration-200">

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left: Dark Editorial Showcase (Hidden on mobile) -->
        <div class="hidden lg:flex lg:col-span-5 relative bg-[#09090B] text-white p-12 flex-col justify-between overflow-hidden border-r border-[#27272A]">
            
            <!-- Subtle Ambient Light Orbs -->
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-emerald-600/10 blur-3xl pointer-events-none"></div>
            
            <!-- Header Brand -->
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#09090B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 21.7C17.3 17 22 13 22 8.5a6.5 6.5 0 00-13 0C9 13 13.7 17 12 21.7z"/>
                            <circle cx="12" cy="8.5" r="2.5"/>
                        </svg>
                    </div>
                    <span style="font-family:'Geist',sans-serif;font-weight:700;font-size:1.375rem;color:#FFFFFF;letter-spacing:-0.03em;">MedCare</span>
                </a>
            </div>

            <!-- Hero Quote / Editorial Content -->
            <div class="relative z-10 max-w-md my-auto py-12">
                <span class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A1A1AA] bg-white/5 border border-white/10 px-3 py-1 rounded-full mb-6">
                    Specialist Healthcare Engine
                </span>
                <h2 style="font-family:'Instrument Serif',serif;font-size:3rem;line-height:1.05;letter-spacing:-0.03em;color:#F4F4F5;">
                    Healthcare designed around <em class="italic text-slate-400">precision & care.</em>
                </h2>
                <p class="mt-6 text-sm text-[#A1A1AA] leading-relaxed">
                    Direct access to 50+ consultants across 10 specialized medical departments. Instant online booking, electronic health records, and transparent billing.
                </p>

                <!-- Micro Stats Strip -->
                @php
                    $docCount = \App\Models\DoctorProfile::active()->count();
                    $deptCount = \App\Models\Department::active()->count();
                @endphp
                <div class="mt-10 grid grid-cols-3 gap-4 pt-8 border-t border-white/10">
                    <div>
                        <p class="text-xl font-bold text-white tracking-tight">{{ $docCount > 50 ? '50+' : $docCount }}</p>
                        <p class="text-[11px] text-[#A1A1AA] mt-0.5">Doctors</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-white tracking-tight">{{ $deptCount }}</p>
                        <p class="text-[11px] text-[#A1A1AA] mt-0.5">Departments</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-white tracking-tight">24/7</p>
                        <p class="text-[11px] text-[#A1A1AA] mt-0.5">Emergency</p>
                    </div>
                </div>
            </div>

            <!-- Footer Meta -->
            <div class="relative z-10 flex items-center justify-between text-xs text-[#71717A] border-t border-white/10 pt-6">
                <span>© {{ date('Y') }} MedCare Hospital</span>
                <span class="inline-flex items-center gap-1.5 text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Systems Operational
                </span>
            </div>
        </div>

        <!-- Right: Auth Form Container -->
        <div class="lg:col-span-7 flex flex-col justify-between p-6 sm:p-12 lg:p-16 relative bg-[#F9FAFB]">
            
            <!-- Top Mobile Logo & Back Button -->
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="lg:hidden inline-flex items-center gap-2">
                    <div class="w-8 h-8 bg-[#18181B] rounded-lg flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                            <path d="M12 21.7C17.3 17 22 13 22 8.5a6.5 6.5 0 00-13 0C9 13 13.7 17 12 21.7z"/>
                            <circle cx="12" cy="8.5" r="2.5"/>
                        </svg>
                    </div>
                    <span class="font-bold text-base text-[#18181B]">MedCare</span>
                </a>
                <a href="{{ route('home') }}" class="text-xs font-medium text-[#71717A] hover:text-[#18181B] transition-colors inline-flex items-center gap-1">
                    ← Back to Home
                </a>
            </div>

            <!-- Central Form Box -->
            <div class="w-full max-w-md mx-auto my-auto py-8">
                {{ $slot }}
            </div>

            <!-- Bottom Disclaimer -->
            <div class="text-center text-[11px] text-[#A1A1AA]">
                Protected by 256-bit HIPAA compliant security. By signing in, you agree to our Terms of Service.
            </div>
        </div>

    </div>

</body>
</html>
