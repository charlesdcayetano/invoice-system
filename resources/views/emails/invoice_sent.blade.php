<h1>Invoice #{{ $invoice->invoice_number }}</h1>
<p>Dear {{ $invoice->client->name }},</p>

<p>Thank you for your business. Please find your invoice attached.</p>

<p>Total: ${{ number_format($invoice->total, 2) }}</p>

<p>Invoice Date: {{ $invoice->invoice_date->format('Y-m-d') }}</p>
<p>Due Date: {{ $invoice->due_date->format('Y-m-d') }}</p>

<p>Best regards,<br>Your Company</p>
<p>If you have any questions regarding this invoice, please contact us at <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.</p>