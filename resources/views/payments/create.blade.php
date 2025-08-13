@extends('layouts.layout')


@section('content')
<h1>Record Payment for Invoice #{{ $invoice->invoice_number }}</h1>


<form method="GET" action="{{ route('products.index') }}" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products" class="border p-2 rounded" />
    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Search</button>
</form>


@if ($errors->any())
<div class="alert alert-danger">
    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('payments.store') }}">
    @csrf
    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
    </div>

    <div class="mb-3">
        <label for="payment_date" class="form-label">Payment Date</label>
        <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
        <label for="payment_method" class="form-label">Payment Method</label>
        <input type="text" name="payment_method" id="payment_method" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Record Payment</button>
</form>
@endsection
{{ $products->links() }}

@section('scripts')