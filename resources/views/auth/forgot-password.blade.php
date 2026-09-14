<x-guest-layout>
    <x-slot name="title">Reset Password</x-slot>

    <div class="mb-6">
        <h1 style="font-family:'Instrument Serif',serif;font-size:2rem;color:#18181B;line-height:1.1;">Reset password</h1>
        <p class="text-xs text-[#71717A] mt-1" style="font-family:'Geist',sans-serif;">Enter your registered email address and we'll send a password reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus placeholder="name@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <button type="submit" class="btn-primary w-full justify-center text-sm py-2.5" style="margin-top:1.25rem;">
            Send Reset Link
        </button>
    </form>

    <div class="mt-6 pt-4 border-t border-[#E4E4E7] text-center text-xs text-[#71717A]">
        Remembered password? 
        <a href="{{ route('login') }}" class="font-semibold text-[#18181B] hover:underline">Return to sign in</a>
    </div>
</x-guest-layout>
