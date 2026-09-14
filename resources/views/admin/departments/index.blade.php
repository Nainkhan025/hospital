<x-dashboard-layout>
    <x-slot name="title">Departments</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Departments</h1>
        <a href="{{ route('admin.departments.create') }}" class="btn-primary-sm">+ Add Department</a>
    </x-slot>

    <x-card>
        <div class="overflow-x-auto -mx-6">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Slug</th>
                        <th>Doctors</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td class="font-medium text-gray-900">{{ $dept->name }}</td>
                        <td class="font-mono text-xs text-[#71717A]">{{ $dept->slug }}</td>
                        <td>{{ $dept->doctor_profiles_count }} doctors</td>
                        <td>
                            @if($dept->is_active)
                                <span class="badge badge-completed">Active</span>
                            @else
                                <span class="badge badge-cancelled">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.departments.edit', $dept->id) }}" class="btn-outline-sm py-1 px-2.5 text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.departments.destroy', $dept->id) }}" onsubmit="return confirm('Delete this department?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger py-1 px-2.5 text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-[#71717A]">No departments created yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-dashboard-layout>
