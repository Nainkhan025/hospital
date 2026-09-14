<x-dashboard-layout>
    <x-slot name="title">My Appointments</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">My Appointments</h1>
        <a href="{{ route('patient.appointments.create') }}" class="btn-primary-sm">+ Book New</a>
    </x-slot>

    <x-card>
        @if($appointments->isEmpty())
            <div class="text-center py-12 text-[#71717A]" style="font-family:'Geist',sans-serif;">
                No appointments found.
                <div class="mt-4"><a href="{{ route('patient.appointments.create') }}" class="btn-primary-sm">Book Your First Appointment</a></div>
            </div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Date & Time</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th>Action</th>
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
                            <td>{{ $appt->doctor->user->name }}</td>
                            <td>{{ $appt->department->name }}</td>
                            <td>${{ number_format($appt->consultation_fee, 2) }}</td>
                            <td><x-status-badge :status="$appt->status" /></td>
                            <td>
                                @if(in_array($appt->status, ['pending', 'confirmed']))
                                <form method="POST" action="{{ route('patient.appointments.cancel', $appt->id) }}" onsubmit="return confirm('Are you sure you want to cancel this appointment?');" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-danger text-xs py-1 px-2.5">Cancel</button>
                                </form>
                                @else
                                <span class="text-xs text-[#A1A1AA]">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#E4E4E7]">
                {{ $appointments->links() }}
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
