<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = $user->invoices()
            ->with('items', 'payments')
            ->latest()
            ->paginate(10);

        return view('patient.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $user = Auth::user();
        if ($invoice->patient_id !== $user->id) {
            abort(403);
        }

        $invoice->load('items', 'payments');
        return view('patient.invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $user = Auth::user();
        if ($invoice->patient_id !== $user->id) {
            abort(403);
        }

        $invoice->load('patient', 'items', 'payments');
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
