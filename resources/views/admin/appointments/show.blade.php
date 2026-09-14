<x-dashboard-layout>
    <x-slot name="title">Admin Appointment #APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">Appointment Overview</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn-primary-sm">Edit Appointment</a>
                <a href="{{ route('admin.appointments.index') }}" class="btn-outline-sm">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl">
        <div class="lg:col-span-2 space-y-6">
            <x-card class="space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#E4E4E7]">
                    <div>
                        <span class="text-xs font-mono text-[#71717A]">#APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $appointment->department->name }} Department</h2>
                    </div>
                    <x-status-badge :status="$appointment->status" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-medium text-[#71717A] uppercase block">Patient</span>
                        <p class="font-medium text-gray-900">{{ $appointment->patient->name }}</p>
                        <p class="text-xs text-[#71717A]">{{ $appointment->patient->email }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-[#71717A] uppercase block">Doctor</span>
                        <p class="font-medium text-gray-900">{{ $appointment->doctor->user->name }}</p>
                        <p class="text-xs text-[#71717A]">{{ $appointment->doctor->specialization }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-[#71717A] uppercase block">Date & Time</span>
                        <p class="font-medium text-gray-900">{{ $appointment->appointment_date->format('F j, Y') }}</p>
                        <p class="text-xs text-[#71717A]">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-[#71717A] uppercase block">Fee</span>
                        <p class="font-medium text-gray-900">${{ number_format($appointment->consultation_fee, 2) }}</p>
                    </div>
                </div>

                <div class="pt-3 border-t border-[#E4E4E7]">
                    <span class="text-xs font-medium text-[#71717A] uppercase block mb-1">Reason for Visit</span>
                    <p class="text-sm text-gray-800">{{ $appointment->reason ?: 'None specified' }}</p>
                </div>
            </x-card>
        </div>

        <div>
            <x-card class="space-y-4">
                <h3 class="font-semibold text-gray-900 border-b border-[#E4E4E7] pb-2">Quick Actions</h3>
                <form method="POST" action="{{ route('admin.appointments.update', $appointment->id) }}" class="space-y-3">
                    @csrf @method('PUT')
                    <div>
                        <label class="form-label">Change Status</label>
                        <select name="status" class="form-select">
                            @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                                <option value="{{ $st }}" {{ $appointment->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center text-sm py-2">Update Status</button>
                </form>

                <form method="POST" action="{{ route('admin.appointments.destroy', $appointment->id) }}" onsubmit="return confirm('Permanently delete this appointment?')" class="pt-3 border-t border-[#E4E4E7]">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger w-full justify-center text-xs py-2">
                        Delete Appointment
                    </button>
                </form>
            </x-card>
        </div>
    </div>
</x-dashboard-layout>
