<x-dashboard-layout>
    <x-slot name="title">Doctors</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Consultants & Doctors</h1>
        <a href="{{ route('admin.doctors.create') }}" class="btn-primary-sm">+ Register New Doctor</a>
    </x-slot>

    <x-card>
        <div class="overflow-x-auto -mx-6">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>Experience</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doc)
                    <tr>
                        <td>
                            <div class="font-medium text-gray-900">{{ $doc->user->name }}</div>
                            <div class="text-xs text-[#71717A]">{{ $doc->user->email }}</div>
                        </td>
                        <td>{{ $doc->department->name ?? '—' }}</td>
                        <td>{{ $doc->specialization }}</td>
                        <td>{{ $doc->years_experience }} yrs</td>
                        <td class="font-medium text-gray-900">${{ number_format($doc->consultation_fee, 2) }}</td>
                        <td>
                            @if($doc->is_active)
                                <span class="badge badge-completed">Active</span>
                            @else
                                <span class="badge badge-cancelled">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.doctors.edit', $doc->id) }}" class="btn-outline-sm py-1 px-2.5 text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.doctors.destroy', $doc->id) }}" onsubmit="return confirm('Delete this doctor user account?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger py-1 px-2.5 text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-[#71717A]">No doctors registered yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#E4E4E7]">
            {{ $doctors->links() }}
        </div>
    </x-card>
</x-dashboard-layout>
