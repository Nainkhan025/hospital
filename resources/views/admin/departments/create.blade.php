<x-dashboard-layout>
    <x-slot name="title">Add Department</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Add Department</h1>
        <a href="{{ route('admin.departments.index') }}" class="btn-outline-sm">Back</a>
    </x-slot>

    <div class="max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.departments.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="form-label">Department Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="e.g. Cardiology" required>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-input resize-none" placeholder="Brief description of clinical services...">{{ old('description') }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded border-[#E4E4E7] text-[#18181B] focus:ring-0">
                    <label for="is_active" class="text-sm font-medium text-gray-900 cursor-pointer">Active (Visible to public)</label>
                </div>

                <div class="pt-4 border-t border-[#E4E4E7] flex justify-end gap-2">
                    <a href="{{ route('admin.departments.index') }}" class="btn-outline-sm">Cancel</a>
                    <button type="submit" class="btn-primary">Create Department</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
