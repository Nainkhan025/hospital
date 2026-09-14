<x-dashboard-layout>
    <x-slot name="title">Register Doctor</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Register Doctor</h1>
        <a href="{{ route('admin.doctors.index') }}" class="btn-outline-sm">Back</a>
    </x-slot>

    <div class="max-w-3xl">
        <x-card>
            <form method="POST" action="{{ route('admin.doctors.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Dr. Jane Smith" required>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="jane@hospital.test" required>
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" value="{{ old('specialization') }}" class="form-input" placeholder="e.g. Pediatric Cardiology" required>
                        @error('specialization') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Qualifications</label>
                        <input type="text" name="qualifications" value="{{ old('qualifications') }}" class="form-input" placeholder="e.g. MD, FACC" required>
                        @error('qualifications') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Years of Experience</label>
                        <input type="number" name="years_experience" value="{{ old('years_experience', 5) }}" class="form-input" min="0" required>
                        @error('years_experience') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Consultation Fee ($)</label>
                        <input type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee', 150.00) }}" class="form-input" min="0" required>
                        @error('consultation_fee') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Biography (Optional)</label>
                    <textarea name="bio" rows="4" class="form-input resize-none" placeholder="Professional bio and research background...">{{ old('bio') }}</textarea>
                    @error('bio') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-[#E4E4E7] flex justify-end gap-2">
                    <a href="{{ route('admin.doctors.index') }}" class="btn-outline-sm">Cancel</a>
                    <button type="submit" class="btn-primary">Register Doctor</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
