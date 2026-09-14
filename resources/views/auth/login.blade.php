<x-guest-layout>
    <x-slot name="title">Sign In</x-slot>

    <!-- Header -->
    <div class="mb-8">
        <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#71717A]">Patient & Staff Portal</span>
        <h1 style="font-family:'Instrument Serif',serif;font-size:2.75rem;color:#18181B;line-height:1.05;letter-spacing:-0.03em;" class="mt-1">
            Sign in to MedCare
        </h1>
        <p class="text-xs text-[#71717A] mt-2 leading-relaxed" style="font-family:'Geist',sans-serif;">
            Access your medical dashboard, scheduled appointments, and prescriptions.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ email: '{{ old('email', '') }}', password: '' }">
        @csrf

        <!-- Email Input with Double Bezel -->
        <div>
            <label for="email" class="form-label">Email Address</label>
            <div class="relative">
                <input id="email" type="email" name="email" x-model="email" class="form-input text-sm py-3 px-4" required autofocus autocomplete="username" placeholder="name@hospital.test">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password Input -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="form-label mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-[#71717A] hover:text-[#18181B] transition-colors">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" x-model="password" class="form-input text-sm py-3 px-4" required autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-[#E4E4E7] text-[#18181B] focus:ring-0">
                <span class="text-xs text-[#71717A]">Keep me signed in</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-primary w-full justify-center text-sm py-3 font-medium shadow-sm hover:shadow transition-all" style="border-radius:8px;">
            Sign In to Account
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>

        <!-- Quick Demo Accounts Widget -->
        <div class="pt-6 mt-8 border-t border-[#E4E4E7] dark:border-[#1F2937]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#A1A1AA] dark:text-[#9CA3AF]">One-Click Demo Fill</span>
                <span class="text-[10px] text-[#A1A1AA] dark:text-[#9CA3AF]">Password: password</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                <button type="button" @click="email='superadmin@hospital.test'; password='password'"
                        class="p-2.5 bg-white dark:bg-[#111827] hover:bg-[#F4F4F5] dark:hover:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-lg text-left transition-all group">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#956400] dark:text-[#FBBF24] block">Super Admin</span>
                    <span class="text-xs font-medium text-[#18181B] dark:text-[#F9FAFB] truncate block">Super Admin</span>
                </button>
                <button type="button" @click="email='admin@hospital.test'; password='password'"
                        class="p-2.5 bg-white dark:bg-[#111827] hover:bg-[#F4F4F5] dark:hover:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-lg text-left transition-all group">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#1F6C9F] dark:text-[#60A5FA] block">Admin</span>
                    <span class="text-xs font-medium text-[#18181B] dark:text-[#F9FAFB] truncate block">Hospital Admin</span>
                </button>
                <button type="button" @click="email='reception@hospital.test'; password='password'"
                        class="p-2.5 bg-white dark:bg-[#111827] hover:bg-[#F4F4F5] dark:hover:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-lg text-left transition-all group">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#346538] dark:text-[#4ADE80] block">Reception</span>
                    <span class="text-xs font-medium text-[#18181B] dark:text-[#F9FAFB] truncate block">Front Desk</span>
                </button>
                <button type="button" @click="email='dr.mitchell@hospital.test'; password='password'"
                        class="p-2.5 bg-white dark:bg-[#111827] hover:bg-[#F4F4F5] dark:hover:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-lg text-left transition-all group">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#1F6C9F] dark:text-[#60A5FA] block">Doctor</span>
                    <span class="text-xs font-medium text-[#18181B] dark:text-[#F9FAFB] truncate block">Dr. Mitchell</span>
                </button>
                <button type="button" @click="email='patient@hospital.test'; password='password'"
                        class="p-2.5 bg-white dark:bg-[#111827] hover:bg-[#F4F4F5] dark:hover:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#1F2937] rounded-lg text-left transition-all group sm:col-span-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#9F2F2D] dark:text-[#F87171] block">Patient</span>
                    <span class="text-xs font-medium text-[#18181B] dark:text-[#F9FAFB] truncate block">John Doe (Patient)</span>
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-[#E4E4E7] dark:border-[#1F2937] text-center text-xs text-[#71717A] dark:text-[#9CA3AF]">
        New to MedCare Hospital? 
        <a href="{{ route('register') }}" class="font-semibold text-[#18181B] dark:text-white hover:underline ml-1">Create an account</a>
    </div>
</x-guest-layout>
