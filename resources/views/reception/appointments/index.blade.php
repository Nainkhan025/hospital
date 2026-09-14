<x-dashboard-layout>
    <x-slot name="title">Reception Appointments Queue</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Reception Desk — Appointment Queue</h1>
        <a href="{{ route('reception.appointments.create') }}" class="btn-primary-sm">+ Book Walk-In Patient</a>
    </x-slot>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('reception.appointments.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="form-label">Date</label>
                <input type="date" name="date" value="{{ request('date', today()->format('Y-m-d')) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary-sm">Filter</button>
        </form>
    </x-card>

    <x-card>
        @if($appointments->isEmpty())
            <div class="text-center py-12 text-[#71717A]" style="font-family:'Geist',sans-serif;">No appointments scheduled for selected date.</div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th>Desk Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                        <tr>
                            <td class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</td>
                            <td>
                                <div class="font-medium text-gray-900">{{ $appt->patient->name }}</div>
                                <div class="text-xs text-[#71717A]">{{ $appt->patient->phone ?? $appt->patient->email }}</div>
                            </td>
                            <td>{{ $appt->doctor->user->name }}</td>
                            <td>{{ $appt->department->name }}</td>
                            <td>${{ number_format($appt->consultation_fee, 2) }}</td>
                            <td><x-status-badge :status="$appt->status" /></td>
                            <td>
                                @if($appt->status === 'pending')
                                    <form method="POST" action="{{ route('reception.appointments.checkin', $appt->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-success py-1 px-3 text-xs">Check In Patient</button>
                                    </form>
                                @else
                                    <span class="text-xs text-[#A1A1AA]">Checked In / Processed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#E4E4E7]">
                {{ $appointments->withQueryString()->links() }}
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
