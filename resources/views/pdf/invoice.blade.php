<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #18181B; font-size: 13px; line-height: 1.5; }
        .header { border-bottom: 2px solid #18181B; padding-bottom: 15px; margin-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; }
        .flex { width: 100%; display: table; margin-bottom: 20px; }
        .col { display: table-cell; width: 50%; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { background: #F4F4F5; text-align: left; padding: 8px; font-size: 11px; text-transform: uppercase; border-bottom: 1px solid #E4E4E7; }
        .table td { padding: 10px 8px; border-bottom: 1px solid #E4E4E7; }
        .total-box { margin-top: 20px; text-align: right; font-size: 14px; }
        .status { padding: 4px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; font-weight: bold; display: inline-block; }
        .paid { background: #EDF3EC; color: #346538; }
        .unpaid { background: #FBF3DB; color: #956400; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">MedCare Hospital</div>
        <div>Invoice #{{ $invoice->invoice_number }}</div>
    </div>

    <div class="flex">
        <div class="col">
            <strong>Billed To:</strong><br>
            {{ $invoice->patient->name }}<br>
            {{ $invoice->patient->email }}<br>
            {{ $invoice->patient->phone ?? '' }}
        </div>
        <div class="col" style="text-align: right;">
            <strong>Date:</strong> {{ $invoice->created_at->format('M j, Y') }}<br>
            <strong>Due Date:</strong> {{ $invoice->due_date->format('M j, Y') }}<br>
            <strong>Status:</strong> <span class="status {{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                <td style="text-align: right;">${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <p>Subtotal: ${{ number_format($invoice->subtotal, 2) }}</p>
        <p>Tax (5%): ${{ number_format($invoice->tax, 2) }}</p>
        <p><strong>Total Amount: ${{ number_format($invoice->total_amount, 2) }}</strong></p>
        <p style="color: #346538;">Amount Paid: ${{ number_format($invoice->amount_paid, 2) }}</p>
        <p style="color: #9F2F2D;"><strong>Balance Due: ${{ number_format($invoice->balance_due, 2) }}</strong></p>
    </div>
</body>
</html>
