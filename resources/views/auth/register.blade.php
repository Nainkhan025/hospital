<x-guest-layout>
    <x-slot name="title">Create Patient Account</x-slot>

    <!-- Header -->
    <div class="mb-8">
        <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#71717A]">Patient Registration</span>
        <h1 style="font-family:'Instrument Serif',serif;font-size:2.75rem;color:#18181B;line-height:1.05;letter-spacing:-0.03em;" class="mt-1">
            Join MedCare Hospital
        </h1>
        <p class="text-xs text-[#71717A] mt-2 leading-relaxed" style="font-family:'Geist',sans-serif;">
            Register as a patient to schedule specialist appointments, track prescriptions, and view medical records online.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name & Email Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-input text-sm py-2.5 px-3.5" required autofocus autocomplete="name" placeholder="John Doe">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div>
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input text-sm py-2.5 px-3.5" required autocomplete="username" placeholder="john@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone" class="form-label">Phone Number (Optional)</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="form-input text-sm py-2.5 px-3.5" placeholder="+1 (555) 000-0000">
            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>

        <!-- Password Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" class="form-input text-sm py-2.5 px-3.5" required autocomplete="new-password" placeholder="Min. 8 chars">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div>
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-input text-sm py-2.5 px-3.5" required autocomplete="new-password" placeholder="Repeat password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-primary w-full justify-center text-sm py-3 font-medium shadow-sm hover:shadow transition-all" style="border-radius:8px;margin-top:1.5rem;">
            Create Patient Account & Book
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-[#E4E4E7] dark:border-[#1F2937] text-center text-xs text-[#71717A] dark:text-[#9CA3AF]">
        Already registered with MedCare? 
        <a href="{{ route('login') }}" class="font-semibold text-[#18181B] dark:text-white hover:underline ml-1">Sign in to your account</a>
    </div>
</x-guest-layout>
