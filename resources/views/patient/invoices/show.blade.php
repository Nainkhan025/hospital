<x-dashboard-layout>
    <x-slot name="title">Invoice #{{ $invoice->invoice_number }}</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Invoice #{{ $invoice->invoice_number }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('patient.invoices.pdf', $invoice->id) }}" class="btn-outline-sm">📥 Download PDF Receipt</a>
            <a href="{{ route('patient.invoices.index') }}" class="btn-outline-sm">Back</a>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <x-card>
            <div class="flex justify-between items-start pb-4 border-b border-[#E4E4E7]">
                <div>
                    <p class="text-xs text-[#71717A]">Patient</p>
                    <p class="text-base font-semibold text-[#18181B]">{{ $invoice->patient->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-[#71717A]">Due Date</p>
                    <p class="text-sm font-medium text-[#18181B]">{{ $invoice->due_date->format('M j, Y') }}</p>
                    <div class="mt-1"><x-status-badge :status="$invoice->status" /></div>
                </div>
            </div>

            <!-- Items -->
            <div class="mt-4 overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                        <tr>
                            <td class="font-medium text-[#18181B]">{{ $item->description }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right font-medium">${{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 pt-4 border-t border-[#E4E4E7] space-y-2 text-sm text-right">
                <div class="flex justify-between text-[#71717A]">
                    <span>Subtotal</span>
                    <span>${{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-[#71717A]">
                    <span>Tax (5%)</span>
                    <span>${{ number_format($invoice->tax, 2) }}</span>
                </div>
                <div class="flex justify-between text-base font-bold text-[#18181B] pt-2 border-t border-[#E4E4E7]">
                    <span>Total Amount</span>
                    <span>${{ number_format($invoice->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm font-semibold text-[#346538]">
                    <span>Amount Paid</span>
                    <span>${{ number_format($invoice->amount_paid, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold text-[#9F2F2D]">
                    <span>Balance Due</span>
                    <span>${{ number_format($invoice->balance_due, 2) }}</span>
                </div>
            </div>
        </x-card>
    </div>
</x-dashboard-layout>
