<x-dashboard-layout>
    <x-slot name="title">Appointment Details #APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">Appointment Details</h1>
            <a href="{{ route('patient.appointments.index') }}" class="btn-outline-sm">Back to Appointments</a>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <x-card class="space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-[#E4E4E7]">
                <div>
                    <span class="text-xs font-mono text-[#71717A]">#APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <h2 class="text-lg font-semibold text-gray-900 mt-0.5">{{ $appointment->department->name }} Consultation</h2>
                </div>
                <x-status-badge :status="$appointment->status" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="text-xs font-medium text-[#71717A] uppercase tracking-wider block mb-1">Doctor</span>
                    <p class="font-medium text-gray-900">{{ $appointment->doctor->user->name }}</p>
                    <p class="text-xs text-[#71717A]">{{ $appointment->doctor->specialization }}</p>
                </div>
                <div>
                    <span class="text-xs font-medium text-[#71717A] uppercase tracking-wider block mb-1">Date & Time</span>
                    <p class="font-medium text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</p>
                    <p class="text-xs text-[#71717A]">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                </div>
                <div>
                    <span class="text-xs font-medium text-[#71717A] uppercase tracking-wider block mb-1">Consultation Fee</span>
                    <p class="font-medium text-gray-900">${{ number_format($appointment->consultation_fee, 2) }}</p>
                </div>
                <div>
                    <span class="text-xs font-medium text-[#71717A] uppercase tracking-wider block mb-1">Reason for Visit</span>
                    <p class="text-sm text-gray-800">{{ $appointment->reason ?: 'General consultation' }}</p>
                </div>
            </div>

            @if(in_array($appointment->status, ['pending', 'confirmed']))
                <div class="pt-4 border-t border-[#E4E4E7] flex justify-end">
                    <form method="POST" action="{{ route('patient.appointments.cancel', $appointment->id) }}" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-danger py-2 px-4 text-sm font-medium">
                            Cancel Appointment
                        </button>
                    </form>
                </div>
            @endif
        </x-card>
    </div>
</x-dashboard-layout>
