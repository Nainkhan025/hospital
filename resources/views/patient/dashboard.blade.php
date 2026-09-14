<x-dashboard-layout>
    <x-slot name="title">My Dashboard</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">My Dashboard</h1>
        <a href="{{ route('patient.appointments.create') }}" class="btn-primary-sm">+ Book Appointment</a>
    </x-slot>

    <div class="space-y-6">
        <!-- Upcoming Appointments -->
        <x-card>
            <x-slot name="header">
                <h2 class="font-semibold text-gray-900">Upcoming Appointments</h2>
                <a href="{{ route('patient.appointments.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
            </x-slot>
            @if($upcoming->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    No upcoming appointments.
                    <div class="mt-4"><a href="{{ route('patient.appointments.create') }}" class="btn-primary-sm">Book Now</a></div>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($upcoming as $appt)
                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex flex-col items-center justify-center text-white shrink-0">
                            <span class="text-xs font-medium">{{ $appt->appointment_date->format('M') }}</span>
                            <span class="text-lg font-bold leading-none">{{ $appt->appointment_date->format('d') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900">{{ $appt->doctor->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $appt->department->name }} · {{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</p>
                        </div>
                        <x-status-badge :status="$appt->status" />
                    </div>
                    @endforeach
                </div>
            @endif
        </x-card>

        <!-- Past Appointments -->
        <x-card>
            <x-slot name="header">
                <h2 class="font-semibold text-gray-900">Past Appointments</h2>
            </x-slot>
            @if($past->isEmpty())
                <p class="text-gray-400 text-sm py-4 text-center">No past appointments.</p>
            @else
                <div class="overflow-x-auto -mx-6 -mb-6">
                    <table class="data-table">
                        <thead><tr><th>Date</th><th>Doctor</th><th>Department</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($past as $appt)
                            <tr>
                                <td>{{ $appt->appointment_date->format('M j, Y') }}</td>
                                <td>{{ $appt->doctor->user->name }}</td>
                                <td>{{ $appt->department->name }}</td>
                                <td><x-status-badge :status="$appt->status" /></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-card>
    </div>
</x-dashboard-layout>
