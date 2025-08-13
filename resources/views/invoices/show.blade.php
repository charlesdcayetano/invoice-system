@extends('layout')

@section('content')
<h1>Invoice: {{ $invoice->invoice_number }}</h1>

<p><strong>Client:</strong> {{ $invoice->client->name }}</p>
<p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}</p>
<p><strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}</p>

<table class="table table-bordered mt-3">
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

<h4>Grand Total: ${{ number_format($invoice->total, 2) }}</h4>

<a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to list</a>
<a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-success" target="_blank">Download PDF</a>
@endsection


@section('scripts')
<script>