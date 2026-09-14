<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('patient', 'payments')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('reception.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $patients = User::role('patient')->select('id', 'name', 'email', 'phone')->orderBy('name')->get();
        $appointment = $request->appointment_id ? Appointment::find($request->appointment_id) : null;

        return view('reception.invoices.create', compact('patients', 'appointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|exists:users,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'due_date'       => 'required|date',
            'items'          => 'required|array|min:1',
            'items.*.desc'   => 'required|string',
            'items.*.price'  => 'required|numeric|min:0',
            'items.*.qty'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += ($item['price'] * $item['qty']);
            }

            $tax   = $subtotal * 0.05; // 5% tax
            $total = $subtotal + $tax;

            $invoice = Invoice::create([
                'patient_id'     => $request->patient_id,
                'appointment_id' => $request->appointment_id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
                'subtotal'       => $subtotal,
                'tax'            => $tax,
                'total_amount'   => $total,
                'status'         => 'unpaid',
                'due_date'       => $request->due_date,
            ]);

            foreach ($request->items as $item) {
                $invoice->items()->create([
                    'description' => $item['desc'],
                    'unit_price'  => $item['price'],
                    'quantity'    => $item['qty'],
                    'total'       => $item['price'] * $item['qty'],
                ]);
            }
        });

        return redirect()->route('reception.invoices.index')->with('success', 'Invoice generated successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('patient', 'appointment.doctor.user', 'items', 'payments');
        return view('reception.invoices.show', compact('invoice'));
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:0.01|max:' . $invoice->balance_due,
            'payment_method' => 'required|in:cash,card,bank_transfer',
        ]);

        DB::transaction(function () use ($request, $invoice) {
            $invoice->payments()->create([
                'amount'         => $request->amount,
                'payment_method' => $request->payment_method,
                'paid_at'        => now(),
            ]);

            if ($invoice->balance_due <= 0) {
                $invoice->update(['status' => 'paid']);
            } else {
                $invoice->update(['status' => 'partially_paid']);
            }
        });

        return back()->with('success', 'Payment of $' . number_format($request->amount, 2) . ' recorded.');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('patient', 'items', 'payments');
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
