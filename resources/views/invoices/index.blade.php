@extends('layout')

@section('content')
<h1>Invoices</h1>

<a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create New Invoice</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Invoice Number</th>
            <th>Client</th>
            <th>Invoice Date</th>
            <th>Due Date</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->client->name }}</td>
            <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
            <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
            <td>${{ number_format($invoice->total, 2) }}</td>
            <td>
                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info btn-sm">View</a>
                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this invoice?')" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
@extends('layouts.layout')
@section('content')