<x-dashboard-layout>
    <x-slot name="title">My Patient Schedule</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">My Appointments Schedule</h1>
    </x-slot>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('doctor.appointments.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="form-label">Filter Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Filter Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-input">
            </div>
            <button type="submit" class="btn-primary-sm">Filter</button>
            @if(request()->hasAny(['status','date']))
                <a href="{{ route('doctor.appointments.index') }}" class="btn-outline-sm">Clear</a>
            @endif
        </form>
    </x-card>

    <x-card>
        @if($appointments->isEmpty())
            <div class="text-center py-12 text-[#71717A]" style="font-family:'Geist',sans-serif;">No appointments scheduled matching filters.</div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Date & Time</th>
                            <th>Patient Name</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appt)
                        <tr>
                            <td class="font-mono text-xs font-semibold">#APT-{{ str_pad($appt->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                {{ $appt->appointment_date->format('M j, Y') }}
                                <span class="text-xs text-[#71717A] block">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}</span>
                            </td>
                            <td>
                                <div class="font-medium text-gray-900">{{ $appt->patient->name }}</div>
                                <div class="text-xs text-[#71717A]">{{ $appt->patient->email }}</div>
                            </td>
                            <td class="text-xs text-[#71717A] max-w-xs truncate">{{ $appt->reason ?? '—' }}</td>
                            <td><x-status-badge :status="$appt->status" /></td>
                            <td>
                                <form method="POST" action="{{ route('doctor.appointments.status', $appt->id) }}" class="inline-flex items-center gap-1">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs border border-[#E4E4E7] rounded px-2 py-1 bg-white font-medium cursor-pointer">
                                        @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                                            <option value="{{ $st }}" {{ $appt->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                        @endforeach
                                    </select>
                                </form>
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
