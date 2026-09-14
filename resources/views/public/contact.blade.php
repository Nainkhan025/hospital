<x-app-layout>
    <x-slot name="title">Contact Us</x-slot>

    <!-- Header Hero: Dark Vantablack Atmosphere -->
    <section class="relative bg-[#09090B] text-white py-24 overflow-hidden border-b border-[#27272A]">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-emerald-600/10 blur-3xl pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center">
            <span class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A1A1AA] bg-white/5 border border-white/10 px-3 py-1 rounded-full mb-4">
                24/7 Patient Services
            </span>
            <h1 style="font-family:'Instrument Serif',serif;font-size:clamp(2.75rem,6vw,4.5rem);line-height:1.05;letter-spacing:-0.03em;color:#F4F4F5;">
                Get in Touch
            </h1>
            <p class="mt-4 text-base text-[#A1A1AA] max-w-xl mx-auto leading-relaxed" style="font-family:'Geist',sans-serif;">
                Have a medical inquiry or need consultation guidance? Our desk team is here to assist you round the clock.
            </p>
        </div>
    </section>

    <!-- Content Section: Asymmetric 50/50 Split -->
    <section class="py-20 bg-[var(--canvas)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            <!-- Left: Info Cards (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Emergency Card -->
                <div class="bg-[var(--surface)] border border-[var(--border-solid)] rounded-xl p-6 relative overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[#FDEBEC] dark:bg-rose-950/60 border border-[#F5C6C7] dark:border-rose-900/60 flex items-center justify-center shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9F2F2D" class="dark:stroke-rose-400" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-300 bg-[#EDF3EC] dark:bg-emerald-950/60 px-2.5 py-1 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> 24/7 Desk Open
                        </span>
                    </div>
                    <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:1rem;" class="text-[#18181B] dark:text-white">Emergency & Trauma</h3>
                    <p class="text-xs text-[#71717A] dark:text-gray-400 mt-1" style="font-family:'Geist',sans-serif;">Direct emergency response line for urgent medical situations.</p>
                    <p class="text-base font-bold text-[#9F2F2D] dark:text-rose-400 mt-3 font-mono">+1 (800) 911-0000</p>
                </div>

                <!-- Hospital Location Card -->
                <div class="bg-[var(--surface)] border border-[var(--border-solid)] rounded-xl p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-[#F4F4F5] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#374151] flex items-center justify-center shrink-0 mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#18181B] dark:text-white" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:1rem;" class="text-[#18181B] dark:text-white">Hospital Address</h3>
                    <p class="text-xs text-[#71717A] dark:text-gray-400 mt-1 leading-relaxed" style="font-family:'Geist',sans-serif;">
                        123 Medical Drive, Health City Campus, Suite 400<br>
                        New York, NY 10001
                    </p>
                    <p class="text-xs text-[#18181B] dark:text-white font-medium mt-3" style="font-family:'Geist',sans-serif;">General Tel: +1 (800) 123-4567</p>
                </div>

                <!-- Working Hours Card -->
                <div class="bg-[var(--surface)] border border-[var(--border-solid)] rounded-xl p-6 shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-[#F4F4F5] dark:bg-[#1F2937] border border-[#E4E4E7] dark:border-[#374151] flex items-center justify-center shrink-0 mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#18181B] dark:text-white" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3 style="font-family:'Geist',sans-serif;font-weight:600;font-size:1rem;" class="text-[#18181B] dark:text-white">OPD Working Hours</h3>
                    <div class="mt-3 space-y-1.5 text-xs text-[#71717A] dark:text-gray-400" style="font-family:'Geist',sans-serif;">
                        <div class="flex justify-between">
                            <span>Monday – Friday</span>
                            <span class="font-medium text-[#18181B] dark:text-white">08:00 AM – 08:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Saturday – Sunday</span>
                            <span class="font-medium text-[#18181B] dark:text-white">09:00 AM – 05:00 PM</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Contact Form Box (7 Cols) -->
            <div class="lg:col-span-7 bg-[var(--surface)] border border-[var(--border-solid)] rounded-xl p-8 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#A1A1AA] dark:text-gray-400 block mb-1">Direct Message</span>
                <h2 style="font-family:'Instrument Serif',serif;font-size:2rem;" class="text-[#18181B] dark:text-white mb-6">
                    Send Us a Message
                </h2>

                <form method="POST" action="{{ route('contact.send') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label">Your Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input text-sm py-2.5 px-3.5" placeholder="John Doe" required>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input text-sm py-2.5 px-3.5" placeholder="john@example.com" required>
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-input text-sm py-2.5 px-3.5" placeholder="Consultation inquiry / General question" required>
                        @error('subject') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="5" class="form-input text-sm py-2.5 px-3.5 resize-none" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                        @error('message') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center text-sm py-3 font-medium shadow-sm hover:shadow transition-all" style="border-radius:8px;margin-top:1.5rem;">
                        Send Message
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>
            </div>

        </div>
    </section>
</x-app-layout>
