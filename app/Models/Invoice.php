<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Customer;
use App\Models\InvoiceItem;


class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'invoice_date',
        'due_date',
        'total_amount'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
    return $this->hasMany(Payment::class);
    }

    public function pdf_data()
{
    $this->load('client', 'items');

    return PDF::loadView('invoices.pdf', ['invoice' => $this])->output();
}
}
