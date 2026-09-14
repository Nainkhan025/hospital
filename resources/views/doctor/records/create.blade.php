<x-dashboard-layout>
    <x-slot name="title">New Medical Record</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Log Medical Consultation Record</h1>
        <a href="{{ route('doctor.records.index') }}" class="btn-outline-sm">Back</a>
    </x-slot>

    <div class="max-w-3xl">
        <x-card>
            <form method="POST" action="{{ route('doctor.records.store') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ rxItems: [{name:'', dosage:'', frequency:'', duration:''}] }">
                @csrf
                @if($appointment)
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                    <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-900">
                        Linking to Appointment #APT-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }} for patient <strong>{{ $appointment->patient->name }}</strong>
                    </div>
                @else
                    <div>
                        <label class="form-label">Select Patient</label>
                        <select name="patient_id" class="form-select" required>
                            <option value="">Choose patient...</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->email }})</option>
                            @endforeach
                        </select>
                        @error('patient_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Consultation Date</label>
                        <input type="date" name="record_date" value="{{ old('record_date', today()->format('Y-m-d')) }}" class="form-input" required>
                        @error('record_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Lab / Clinical Report File (Optional)</label>
                        <input type="file" name="document" class="form-input text-xs">
                        @error('document') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Clinical Diagnosis</label>
                    <textarea name="diagnosis" rows="3" class="form-input resize-none" placeholder="Primary diagnosis and clinical findings..." required>{{ old('diagnosis') }}</textarea>
                    @error('diagnosis') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Treatment Plan & Advice</label>
                    <textarea name="treatment_plan" rows="3" class="form-input resize-none" placeholder="Recommended treatment, lifestyle changes, follow-up date...">{{ old('treatment_plan') }}</textarea>
                    @error('treatment_plan') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <!-- Prescriptions Repeater -->
                <div class="pt-4 border-t border-[#E4E4E7]">
                    <div class="flex items-center justify-between mb-3">
                        <label class="form-label mb-0">Prescribed Medications (Rx)</label>
                        <button type="button" @click="rxItems.push({name:'', dosage:'', frequency:'', duration:''})" class="btn-outline-sm py-1 text-xs">+ Add Medication</button>
                    </div>

                    <template x-for="(item, index) in rxItems" :key="index">
                        <div class="grid grid-cols-12 gap-2 mb-3 p-3 border border-[#E4E4E7] rounded-lg bg-[#FAFAFA]">
                            <div class="col-span-4">
                                <input type="text" :name="`medications[${index}][name]`" x-model="item.name" class="form-input text-xs" placeholder="Medication Name">
                            </div>
                            <div class="col-span-2">
                                <input type="text" :name="`medications[${index}][dosage]`" x-model="item.dosage" class="form-input text-xs" placeholder="Dosage (500mg)">
                            </div>
                            <div class="col-span-3">
                                <input type="text" :name="`medications[${index}][frequency]`" x-model="item.frequency" class="form-input text-xs" placeholder="Freq (Twice daily)">
                            </div>
                            <div class="col-span-2">
                                <input type="text" :name="`medications[${index}][duration]`" x-model="item.duration" class="form-input text-xs" placeholder="Duration (7 days)">
                            </div>
                            <div class="col-span-1 flex items-center justify-center">
                                <button type="button" @click="rxItems.splice(index, 1)" x-show="rxItems.length > 1" class="text-red-500 hover:text-red-700 text-xs font-bold">&times;</button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-4 border-t border-[#E4E4E7] flex justify-end gap-2">
                    <a href="{{ route('doctor.records.index') }}" class="btn-outline-sm">Cancel</a>
                    <button type="submit" class="btn-primary">Save Medical Record</button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>
