<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceSent extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        return $this->subject('Your Invoice ' . $this->invoice->invoice_number)
                    ->view('emails.invoice_sent')
                    ->attachData($this->invoice->pdf_data(), 'invoice_'.$this->invoice->invoice_number.'.pdf');
    }
}
