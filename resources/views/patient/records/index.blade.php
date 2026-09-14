<x-dashboard-layout>
    <x-slot name="title">My Medical Records</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">My Medical Records & Prescriptions</h1>
    </x-slot>

    <x-card>
        @if($records->isEmpty())
            <div class="text-center py-12 text-[#71717A]" style="font-family:'Geist',sans-serif;">No medical records found.</div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Diagnosis</th>
                            <th>Prescriptions</th>
                            <th>Report File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $rec)
                        <tr>
                            <td class="font-medium text-gray-900">{{ $rec->record_date->format('M j, Y') }}</td>
                            <td>{{ $rec->doctor->user->name }}</td>
                            <td>{{ $rec->doctor->department->name ?? '—' }}</td>
                            <td class="max-w-xs truncate">{{ $rec->diagnosis }}</td>
                            <td><span class="badge badge-confirmed">{{ $rec->prescriptions->count() }} items</span></td>
                            <td>
                                @if($rec->hasMedia('medical_documents'))
                                    <a href="{{ route('documents.download', $rec->getFirstMedia('medical_documents')) }}" target="_blank" class="text-xs text-blue-600 underline">Download</a>
                                @else
                                    <span class="text-xs text-[#A1A1AA]">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('patient.records.show', $rec->id) }}" class="btn-outline-sm py-1 px-2.5 text-xs">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#E4E4E7]">
                {{ $records->links() }}
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
