<x-dashboard-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Admin Dashboard</h1>
        <span class="text-sm text-gray-500">{{ now()->format('l, F j Y') }}</span>
    </x-slot>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        <div class="stat-card">
            <div class="stat-icon bg-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="stat-value">{{ $stats['appointments_today'] }}</p>
                <p class="stat-label">Appointments Today</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-emerald-100">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="stat-value">{{ $stats['total_doctors'] }}</p>
                <p class="stat-label">Active Doctors</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-purple-100">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div>
                <p class="stat-value">{{ $stats['total_departments'] }}</p>
                <p class="stat-label">Departments</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-orange-100">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <p class="stat-value">{{ $stats['total_patients'] }}</p>
                <p class="stat-label">Total Patients</p>
            </div>
        </div>
    </div>

    {{-- Recent Appointments --}}
    <x-card>
        <x-slot name="header">
            <h2 class="font-semibold text-gray-900">Recent Appointments</h2>
            <a href="{{ route('admin.appointments.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
        </x-slot>

        <div class="overflow-x-auto -mx-6 -mb-6">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_appointments as $appt)
                    <tr>
                        <td class="font-medium text-gray-900">{{ $appt->patient->name }}</td>
                        <td>{{ $appt->doctor->user->name }}</td>
                        <td>{{ $appt->department->name }}</td>
                        <td>{{ $appt->appointment_date->format('M j, Y') }} at {{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</td>
                        <td><x-status-badge :status="$appt->status" /></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-8">No appointments yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

</x-dashboard-layout>
