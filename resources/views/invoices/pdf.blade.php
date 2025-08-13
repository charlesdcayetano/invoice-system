<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        h2, h3 { margin: 0; }
    </style>
</head>
<body>
    <h2>Invoice #{{ $invoice->invoice_number }}</h2>
    <p><strong>Client:</strong> {{ $invoice->client->name }}</p>
    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}</p>
    <p><strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}</p>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: ${{ number_format($invoice->total, 2) }}</h3>
</body>
</html>
