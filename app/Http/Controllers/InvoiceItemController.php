<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    public function index()
    {
        return InvoiceItem::all(); // List all invoice items
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'description' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $invoiceItem = InvoiceItem::create($validated);

        return response()->json($invoiceItem, 201);
    }

    public function show(InvoiceItem $invoiceItem)
    {
        return $invoiceItem;
    }

    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        $validated = $request->validate([
            'description' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $invoiceItem->update($validated);

        return response()->json($invoiceItem);
    }

    public function destroy(InvoiceItem $invoiceItem)
    {
        $invoiceItem->delete();
        return response()->json(null, 204);
    }
}
