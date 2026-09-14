<x-dashboard-layout>
    <x-slot name="title">My Invoices</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">My Medical Invoices</h1>
    </x-slot>

    <x-card>
        @if($invoices->isEmpty())
            <div class="text-center py-12 text-[#71717A]" style="font-family:'Geist',sans-serif;">No invoices issued yet.</div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Total Amount</th>
                            <th>Amount Paid</th>
                            <th>Balance Due</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $inv)
                        <tr>
                            <td class="font-mono text-xs font-semibold">{{ $inv->invoice_number }}</td>
                            <td class="font-medium text-gray-900">${{ number_format($inv->total_amount, 2) }}</td>
                            <td class="text-[#346538]">${{ number_format($inv->amount_paid, 2) }}</td>
                            <td class="font-medium text-[#9F2F2D]">${{ number_format($inv->balance_due, 2) }}</td>
                            <td>{{ $inv->due_date->format('M j, Y') }}</td>
                            <td><x-status-badge :status="$inv->status" /></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('patient.invoices.show', $inv->id) }}" class="btn-outline-sm py-1 px-2.5 text-xs">View</a>
                                    <a href="{{ route('patient.invoices.pdf', $inv->id) }}" class="btn-outline-sm py-1 px-2.5 text-xs">Download PDF</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#E4E4E7]">
                {{ $invoices->links() }}
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
