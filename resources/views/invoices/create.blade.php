@extends('layout')

@section('content')
<h1>Create Invoice</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('invoices.store') }}">
    @csrf

    <div class="mb-3">
        <label for="client_id" class="form-label">Client</label>
        <select name="client_id" id="client_id" class="form-select" required>
            <option value="">Select Client</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="invoice_number" class="form-label">Invoice Number</label>
        <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="{{ old('invoice_number') }}" required>
    </div>

    <div class="mb-3">
        <label for="invoice_date" class="form-label">Invoice Date</label>
        <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
    </div>

    <hr>

    <h4>Invoice Items</h4>
    <table class="table" id="invoice-items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th><button type="button" class="btn btn-success btn-sm" id="add-item-btn">+</button></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="items[0][description]" class="form-control" required></td>
                <td><input type="number" name="items[0][quantity]" class="form-control item-qty" min="1" value="1" required></td>
                <td><input type="number" name="items[0][unit_price]" class="form-control item-unit-price" min="0" step="0.01" value="0.00" required></td>
                <td class="item-total">$0.00</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item-btn">x</button></td>
            </tr>
        </tbody>
    </table>

    <div class="mb-3">
        <strong>Grand Total: $<span id="grand-total">0.00</span></strong>
    </div>

    <button type="submit" class="btn btn-primary">Save Invoice</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addItemBtn = document.getElementById('add-item-btn');
        const tableBody = document.querySelector('#invoice-items-table tbody');
        let itemIndex = 1;

        function updateTotals() {
            let grandTotal = 0;
            document.querySelectorAll('#invoice-items-table tbody tr').forEach(row => {
                const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                const unitPrice = parseFloat(row.querySelector('.item-unit-price').value) || 0;
                const total = qty * unitPrice;
                row.querySelector('.item-total').textContent = '$' + total.toFixed(2);
                grandTotal += total;
            });
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        }

        addItemBtn.addEventListener('click', () => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="items[${itemIndex}][description]" class="form-control" required></td>
                <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control item-qty" min="1" value="1" required></td>
                <td><input type="number" name="items[${itemIndex}][unit_price]" class="form-control item-unit-price" min="0" step="0.01" value="0.00" required></td>
                <td class="item-total">$0.00</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item-btn">x</button></td>
            `;
            tableBody.appendChild(newRow);
            itemIndex++;
        });

        tableBody.addEventListener('input', function(e) {
            if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-unit-price')) {
                updateTotals();
            }
        });

        tableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item-btn')) {
                const row = e.target.closest('tr');
                if(document.querySelectorAll('#invoice-items-table tbody tr').length > 1){
                    row.remove();
                    updateTotals();
                }
            }
        });

        updateTotals();
    });
</script>
@endsection
@extends('layouts.layout')
@section('content')