<x-dashboard-layout>
    <x-slot name="title">Doctor Dashboard</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">My Dashboard</h1>
        <span class="text-sm text-gray-500">{{ now()->format('l, F j Y') }}</span>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
        <div class="stat-card">
            <div class="stat-icon bg-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="stat-value">{{ $today_appointments->count() }}</p>
                <p class="stat-label">Appointments Today</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-emerald-100">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="stat-value">{{ $upcoming_count }}</p>
                <p class="stat-label">Upcoming Total</p>
            </div>
        </div>
    </div>

    <x-card>
        <x-slot name="header">
            <h2 class="font-semibold text-gray-900">Today's Schedule</h2>
        </x-slot>
        @if($today_appointments->isEmpty())
            <div class="text-center py-10 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                No appointments scheduled for today.
            </div>
        @else
            <div class="overflow-x-auto -mx-6 -mb-6">
                <table class="data-table">
                    <thead><tr><th>Time</th><th>Patient</th><th>Reason</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($today_appointments as $appt)
                        <tr>
                            <td class="font-medium">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</td>
                            <td>{{ $appt->patient->name }}</td>
                            <td class="text-gray-500 max-w-xs truncate">{{ $appt->reason ?? '—' }}</td>
                            <td><x-status-badge :status="$appt->status" /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
