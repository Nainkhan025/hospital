<div class="px-4 pt-4 z-50 relative" x-data="{ open: false }">
    <nav class="max-w-5xl mx-auto bg-white dark:bg-[#111827] border border-[#E4E4E7] dark:border-[#1F2937] rounded-xl px-5 h-14 flex items-center justify-between"
         style="box-shadow: 0 1px 4px rgba(0,0,0,0.04);">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0">
            <div class="w-7 h-7 bg-[#18181B] dark:bg-white rounded-md flex items-center justify-center">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white dark:text-[#18181B]" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21.7C17.3 17 22 13 22 8.5a6.5 6.5 0 00-13 0C9 13 13.7 17 12 21.7z"/>
                    <circle cx="12" cy="8.5" r="2.5"/>
                </svg>
            </div>
            <span style="font-family:'Geist',sans-serif;font-weight:600;font-size:0.9375rem;" class="text-[#18181B] dark:text-white tracking-tight">MedCare</span>
        </a>

        <!-- Desktop nav links -->
        <div class="hidden md:flex items-center gap-0.5">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">Home</a>
            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'nav-link-active' : '' }}">Departments</a>
            <a href="{{ route('doctors.index') }}" class="nav-link {{ request()->routeIs('doctors.*') ? 'nav-link-active' : '' }}">Doctors</a>
            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">Contact</a>
        </div>

        <!-- Auth controls & Dark Mode Toggle -->
        <div class="hidden md:flex items-center gap-2">
            <!-- Theme Toggle -->
            <button x-data="{ dark: document.documentElement.classList.contains('dark') }"
                    @click="dark = !dark; if (dark) { document.documentElement.classList.add('dark'); localStorage.setItem('theme', 'dark'); } else { document.documentElement.classList.remove('dark'); localStorage.setItem('theme', 'light'); }"
                    class="w-8 h-8 rounded-md flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#1F2937] transition-colors"
                    title="Toggle Theme">
                <svg x-show="!dark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg x-show="dark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </button>

            @auth
                <a href="{{ route('dashboard') }}" class="btn-outline-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-link">Sign in</a>
                <a href="{{ route('register') }}" class="btn-primary-sm">Book Appointment</a>
            @endauth
        </div>

        <!-- Mobile toggle -->
        <button @click="open = !open"
                class="md:hidden w-8 h-8 flex items-center justify-center rounded-md border border-[#E4E4E7] text-[#71717A] hover:text-[#18181B] transition-colors"
                aria-label="Toggle menu">
            <svg x-show="!open" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg x-show="open"  width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </nav>

    <!-- Mobile menu -->
    <div x-show="open"
         x-transition:enter="transition duration-200 ease-[cubic-bezier(0.16,1,0.3,1)]"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition duration-150"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="max-w-5xl mx-auto mt-1 bg-white border border-[#E4E4E7] rounded-xl p-3 space-y-0.5"
         style="box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
        <a href="{{ route('home') }}"            class="mobile-nav-link">Home</a>
        <a href="{{ route('departments.index') }}" class="mobile-nav-link">Departments</a>
        <a href="{{ route('doctors.index') }}"    class="mobile-nav-link">Doctors</a>
        <a href="{{ route('contact') }}"          class="mobile-nav-link">Contact</a>
        <hr class="border-[#E4E4E7] my-2">
        @auth
            <a href="{{ route('dashboard') }}" class="mobile-nav-link font-medium" style="color:#18181B;">Dashboard</a>
        @else
            <a href="{{ route('login') }}"    class="mobile-nav-link">Sign in</a>
            <a href="{{ route('register') }}" class="mobile-nav-link font-medium" style="color:#18181B;">Book Appointment</a>
        @endauth
    </div>
</div>
