<x-dashboard-layout>
    <x-slot name="title">Reception Dashboard</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Reception Dashboard</h1>
        <div class="flex gap-2">
            <a href="{{ route('reception.appointments.create') }}" class="btn-primary-sm">+ Walk-In Booking</a>
        </div>
    </x-slot>

    <x-card>
        <x-slot name="header">
            <h2 class="font-semibold text-gray-900">Today's Appointments — {{ now()->format('l, F j') }}</h2>
            <span class="text-sm text-gray-500">{{ $today_appointments->count() }} total</span>
        </x-slot>

        @if($today_appointments->isEmpty())
            <div class="text-center py-12 text-gray-400">No appointments scheduled for today.</div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($today_appointments as $appt)
                        <tr>
                            <td class="font-medium">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</td>
                            <td class="font-medium text-gray-900">{{ $appt->patient->name }}</td>
                            <td>{{ $appt->doctor->user->name }}</td>
                            <td>{{ $appt->department->name }}</td>
                            <td><x-status-badge :status="$appt->status" /></td>
                            <td>
                                @if($appt->status === 'pending')
                                <form method="POST" action="{{ route('reception.appointments.checkin', $appt) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-success text-xs py-1 px-3">Check In</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
