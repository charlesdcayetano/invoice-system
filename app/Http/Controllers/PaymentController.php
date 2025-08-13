<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $invoiceId = $request->invoice_id;
        $invoice = Invoice::findOrFail($invoiceId);

        return view('payments.create', compact('invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
        ]);

        Payment::create($request->all());

        // Optionally update invoice status if fully paid
        $invoice = Invoice::find($request->invoice_id);
        $totalPaid = $invoice->payments()->sum('amount');
        if ($totalPaid >= $invoice->total) {
            $invoice->update(['status' => 'paid']);
        }

        return redirect()->route('invoices.show', $invoice)->with('success', 'Payment recorded successfully.');
    }
}
