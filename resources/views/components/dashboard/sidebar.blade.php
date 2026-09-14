<aside class="hidden lg:flex flex-col w-64 bg-[#18181B] text-gray-300 h-screen sticky top-0 shrink-0 border-r border-[#27272A] z-30">
    <!-- Logo -->
    <div class="h-16 px-5 flex items-center border-b border-[#27272A]">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#18181B" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 21.7C17.3 17 22 13 22 8.5a6.5 6.5 0 00-13 0C9 13 13.7 17 12 21.7z"/>
                    <circle cx="12" cy="8.5" r="2.5"/>
                </svg>
            </div>
            <span style="font-family:'Geist',sans-serif;font-weight:700;font-size:1.125rem;color:#FFFFFF;letter-spacing:-0.02em;">MedCare</span>
        </a>
    </div>

    <!-- Role Badge -->
    <div class="h-16 px-5 flex items-center border-b border-[#27272A]">
        @php $user = auth()->user(); @endphp
        <span class="text-[10px] font-bold uppercase tracking-wider text-[#A1A1AA]">
            {{ str_replace('_', ' ', $user->getRoleNames()->first() ?? 'User') }}
        </span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        @php $user = auth()->user(); @endphp

        {{-- Admin & Super Admin --}}
        @if($user->isAdmin())
            <x-dashboard.nav-item route="admin.dashboard" icon="grid" label="Dashboard" />
            <x-dashboard.nav-item route="admin.departments.index" icon="tag" label="Departments" />
            <x-dashboard.nav-item route="admin.doctors.index" icon="users" label="Doctors" />
            <x-dashboard.nav-item route="admin.appointments.index" icon="calendar" label="Appointments" />
        @endif

        {{-- Doctor --}}
        @if($user->isDoctor())
            <x-dashboard.nav-item route="doctor.dashboard" icon="grid" label="Dashboard" />
            <x-dashboard.nav-item route="doctor.appointments.index" icon="calendar" label="My Schedule" />
            <x-dashboard.nav-item route="doctor.records.index" icon="file" label="Clinical Records" />
        @endif

        {{-- Patient --}}
        @if($user->isPatient())
            <x-dashboard.nav-item route="patient.dashboard" icon="grid" label="Dashboard" />
            <x-dashboard.nav-item route="patient.appointments.index" icon="calendar" label="My Appointments" />
            <x-dashboard.nav-item route="patient.appointments.create" icon="plus" label="Book Appointment" />
            <x-dashboard.nav-item route="patient.records.index" icon="file" label="Medical Records" />
            <x-dashboard.nav-item route="patient.invoices.index" icon="chart" label="Invoices & Receipts" />
        @endif

        {{-- Receptionist --}}
        @if($user->isReceptionist())
            <x-dashboard.nav-item route="reception.dashboard" icon="grid" label="Dashboard" />
            <x-dashboard.nav-item route="reception.appointments.index" icon="calendar" label="Appointments" />
            <x-dashboard.nav-item route="reception.appointments.create" icon="plus" label="Walk-In Booking" />
            <x-dashboard.nav-item route="reception.invoices.index" icon="chart" label="Invoices & Billing" />
        @endif

        <!-- Shared -->
        <div class="pt-4 mt-4 border-t border-[#27272A] space-y-0.5">
            <x-dashboard.nav-item route="profile.edit" icon="user" label="My Profile" />
        </div>
    </nav>

    <!-- User Info -->
    <div class="px-5 py-4 border-t border-[#27272A]">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-white text-[#18181B] flex items-center justify-center font-bold text-xs" style="font-family:'Geist',sans-serif;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-white truncate" style="font-family:'Geist',sans-serif;">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-[#71717A] truncate" style="font-family:'Geist',sans-serif;">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
