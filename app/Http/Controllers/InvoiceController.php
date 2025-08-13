<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Barryvdh\DomPDF\Facade\Pdf;  // or just use PDF if aliased in config/app.php
use Illuminate\Http\Request;
use App\Mail\InvoiceSent;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    /**
     * Display all invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('customer', 'items')->get();
        return response()->json($invoices);
    }

    /**
     * Store a new invoice.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:invoices',
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calculate total
        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        // Create invoice
        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'customer_id' => $request->customer_id,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'total_amount' => $totalAmount,
        ]);

        // Add items
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return response()->json([
            'message' => 'Invoice created successfully',
            'invoice' => $invoice->load('items')
        ], 201);
    }

    /**
     * Show a single invoice.
     */
    public function show($id)
    {
        $invoice = Invoice::with('customer', 'items')->findOrFail($id);
        return response()->json($invoice);
    }

    /**
     * Delete an invoice.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully']);
    }

    public function pdf(Invoice $invoice)
    {
    $invoice->load('client', 'items');

    $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

    return $pdf->download('Invoice_'.$invoice->invoice_number.'.pdf');
    }

    public function send(Invoice $invoice)
    {
    $invoice->update(['status' => 'sent']);

    Mail::to($invoice->client->email)->send(new InvoiceSent($invoice));

    return back()->with('success', 'Invoice emailed to client.');
    }

}
