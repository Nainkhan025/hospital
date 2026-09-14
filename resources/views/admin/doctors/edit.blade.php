<x-dashboard-layout>
    <x-slot name="title">Edit Doctor</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Edit {{ $doctor->user->name }}</h1>
        <a href="{{ route('admin.doctors.index') }}" class="btn-outline-sm">Back</a>
    </x-slot>

    <div class="max-w-3xl">
        <x-card>
            <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}" class="space-y-5">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $doctor->user->name) }}" class="form-input" required>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $doctor->user->email) }}" class="form-input" required>
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••">
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" class="form-input" required>
                        @error('specialization') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Qualifications</label>
                        <input type="text" name="qualifications" value="{{ old('qualifications', $doctor->qualifications) }}" class="form-input" required>
                        @error('qualifications') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Years of Experience</label>
                        <input type="number" name="years_experience" value="{{ old('years_experience', $doctor->years_experience) }}" class="form-input" min="0" required>
                        @error('years_experience') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Consultation Fee ($)</label>
                        <input type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" class="form-input" min="0" required>
                        @error('consultation_fee') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Biography</label>
                    <textarea name="bio" rows="4" class="form-input resize-none">{{ old('bio', $doctor->bio) }}</textarea>
                    @error('bio') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $doctor->is_active) ? 'checked' : '' }} class="rounded border-[#E4E4E7] text-[#18181B] focus:ring-0">
                    <label for="is_active" class="text-sm font-medium text-gray-900 cursor-pointer">Active Doctor Profile</label>
                </div>

                <div class="pt-4 border-t border-[#E4E4E7] flex justify-end gap-2">
                    <a href="{{ route('admin.doctors.index') }}" class="btn-outline-sm">Cancel</a>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
