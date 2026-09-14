<x-dashboard-layout>
    <x-slot name="title">Medical Record Detail</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Consultation Record — {{ $record->record_date->format('M j, Y') }}</h1>
        <a href="{{ route('patient.records.index') }}" class="btn-outline-sm">Back</a>
    </x-slot>

    <div class="max-w-3xl space-y-6">
        <x-card>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-[#E4E4E7]">
                    <div>
                        <p class="text-xs text-[#71717A]">Consultant</p>
                        <p class="text-base font-semibold text-[#18181B]">{{ $record->doctor->user->name }}</p>
                        <p class="text-xs text-[#71717A]">{{ $record->doctor->department->name ?? '' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-[#71717A]">Date</p>
                        <p class="text-sm font-medium text-[#18181B]">{{ $record->record_date->format('l, F j, Y') }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-semibold text-[#71717A] uppercase tracking-wider mb-1">Diagnosis</h3>
                    <p class="text-sm text-[#18181B] leading-relaxed bg-[#FAFAFA] p-3 rounded-lg border border-[#E4E4E7]">{{ $record->diagnosis }}</p>
                </div>

                @if($record->treatment_plan)
                <div>
                    <h3 class="text-xs font-semibold text-[#71717A] uppercase tracking-wider mb-1">Treatment Plan & Advice</h3>
                    <p class="text-sm text-[#18181B] leading-relaxed bg-[#FAFAFA] p-3 rounded-lg border border-[#E4E4E7]">{{ $record->treatment_plan }}</p>
                </div>
                @endif

                @if($record->prescriptions->isNotEmpty())
                <div>
                    <h3 class="text-xs font-semibold text-[#71717A] uppercase tracking-wider mb-2">Prescribed Medications (Rx)</h3>
                    <div class="border border-[#E4E4E7] rounded-lg divide-y divide-[#E4E4E7]">
                        @foreach($record->prescriptions as $rx)
                        <div class="p-3 flex justify-between items-center text-sm">
                            <div>
                                <span class="font-semibold text-[#18181B]">{{ $rx->medication_name }}</span>
                                <span class="text-xs text-[#71717A] ml-2">({{ $rx->dosage }})</span>
                            </div>
                            <div class="text-xs text-[#71717A]">
                                {{ $rx->frequency }} · {{ $rx->duration }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($record->hasMedia('medical_documents'))
                <div class="pt-3 border-t border-[#E4E4E7]">
                    <span class="text-xs font-semibold text-[#71717A] uppercase tracking-wider block mb-2">Lab & Clinical Reports</span>
                    <a href="{{ route('documents.download', $record->getFirstMedia('medical_documents')) }}" target="_blank" class="btn-outline-sm py-1.5 px-3">
                        📎 Download Attachment ({{ $record->getFirstMedia('medical_documents')->file_name }})
                    </a>
                </div>
                @endif
            </div>
        </x-card>
    </div>
</x-dashboard-layout>
