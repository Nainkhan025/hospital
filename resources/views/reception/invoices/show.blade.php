<x-dashboard-layout>
    <x-slot name="title">Invoice #{{ $invoice->invoice_number }}</x-slot>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Invoice #{{ $invoice->invoice_number }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('reception.invoices.pdf', $invoice->id) }}" class="btn-outline-sm">📥 Download PDF</a>
            <a href="{{ route('reception.invoices.index') }}" class="btn-outline-sm">Back</a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Invoice Details -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <div class="flex justify-between items-start pb-4 border-b border-[#E4E4E7]">
                    <div>
                        <p class="text-xs text-[#71717A]">Billed To</p>
                        <p class="text-base font-semibold text-[#18181B]">{{ $invoice->patient->name }}</p>
                        <p class="text-xs text-[#71717A]">{{ $invoice->patient->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-[#71717A]">Due Date</p>
                        <p class="text-sm font-medium text-[#18181B]">{{ $invoice->due_date->format('M j, Y') }}</p>
                        <div class="mt-1"><x-status-badge :status="$invoice->status" /></div>
                    </div>
                </div>

                <!-- Line Items Table -->
                <div class="mt-4 overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Unit Price</th>
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

                <!-- Summary Totals -->
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

            <!-- Payment History -->
            <x-card>
                <x-slot name="header">
                    <h2 class="font-semibold text-gray-900">Payment Transactions</h2>
                </x-slot>

                @if($invoice->payments->isEmpty())
                    <p class="text-xs text-[#71717A] py-2">No payments recorded yet.</p>
                @else
                    <div class="divide-y divide-[#E4E4E7]">
                        @foreach($invoice->payments as $pmt)
                        <div class="py-2.5 flex justify-between items-center text-xs">
                            <div>
                                <span class="font-semibold text-[#18181B]">${{ number_format($pmt->amount, 2) }}</span>
                                <span class="text-[#71717A] ml-2">via {{ strtoupper(str_replace('_',' ',$pmt->payment_method)) }}</span>
                            </div>
                            <span class="text-[#71717A]">{{ $pmt->paid_at->format('M j, Y g:i A') }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Right: Record Payment Form -->
        <div>
            <x-card>
                <x-slot name="header">
                    <h2 class="font-semibold text-gray-900">Record Payment</h2>
                </x-slot>

                @if($invoice->balance_due <= 0)
                    <div class="p-3 bg-[#EDF3EC] border border-[#C4DBBC] rounded-lg text-xs font-semibold text-[#346538] text-center">
                        ✓ Invoice Fully Paid
                    </div>
                @else
                    <form method="POST" action="{{ route('reception.invoices.payments', $invoice->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="form-label">Payment Amount ($)</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount', $invoice->balance_due) }}" max="{{ $invoice->balance_due }}" class="form-input" required>
                            <span class="text-[10px] text-[#71717A] mt-1 block">Max payable: ${{ number_format($invoice->balance_due, 2) }}</span>
                        </div>

                        <div>
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">Cash Desk</option>
                                <option value="card">Credit / Debit Card</option>
                                <option value="bank_transfer">Bank Wire Transfer</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-success w-full justify-center">Record Payment</button>
                    </form>
                @endif
            </x-card>
        </div>

    </div>
</x-dashboard-layout>
