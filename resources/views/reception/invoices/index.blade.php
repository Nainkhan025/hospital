<x-dashboard-layout>
    <x-slot name="title">Invoices & Billing</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Invoices & Billing</h1>
        <a href="{{ route('reception.invoices.create') }}" class="btn-primary-sm">+ Generate Invoice</a>
    </x-slot>

    <!-- Filters -->
    <x-card class="mb-6">
        <form method="GET" action="{{ route('reception.invoices.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="form-label">Filter Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['unpaid','paid','partially_paid','cancelled'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary-sm">Filter</button>
            @if(request()->has('status'))
                <a href="{{ route('reception.invoices.index') }}" class="btn-outline-sm">Clear</a>
            @endif
        </form>
    </x-card>

    <x-card>
        @if($invoices->isEmpty())
            <div class="text-center py-12 text-[#71717A]" style="font-family:'Geist',sans-serif;">No invoices logged.</div>
        @else
            <div class="overflow-x-auto -mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Patient</th>
                            <th>Total</th>
                            <th>Balance Due</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $inv)
                        <tr>
                            <td class="font-mono text-xs font-semibold">{{ $inv->invoice_number }}</td>
                            <td>
                                <div class="font-medium text-gray-900">{{ $inv->patient->name }}</div>
                            </td>
                            <td class="font-medium text-gray-900">${{ number_format($inv->total_amount, 2) }}</td>
                            <td class="font-medium text-[#9F2F2D]">${{ number_format($inv->balance_due, 2) }}</td>
                            <td>{{ $inv->due_date->format('M j, Y') }}</td>
                            <td><x-status-badge :status="$inv->status" /></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('reception.invoices.show', $inv->id) }}" class="btn-outline-sm py-1 px-2.5 text-xs">View & Pay</a>
                                    <a href="{{ route('reception.invoices.pdf', $inv->id) }}" class="btn-outline-sm py-1 px-2.5 text-xs">PDF</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#E4E4E7]">
                {{ $invoices->withQueryString()->links() }}
            </div>
        @endif
    </x-card>
</x-dashboard-layout>
