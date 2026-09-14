<x-dashboard-layout>
    <x-slot name="title">Edit Appointment #APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">Edit Appointment</h1>
            <a href="{{ route('admin.appointments.index') }}" class="btn-outline-sm">Cancel</a>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.appointments.update', $appointment->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending','confirmed','completed','cancelled','no_show'] as $st)
                            <option value="{{ $st }}" {{ old('status', $appointment->status) === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E4E4E7]">
                    <a href="{{ route('admin.appointments.index') }}" class="btn-outline-sm py-2 px-4">Cancel</a>
                    <button type="submit" class="btn-primary-sm py-2 px-4">Save Changes</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
