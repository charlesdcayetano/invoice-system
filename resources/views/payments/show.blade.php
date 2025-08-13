<a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success mb-3">Record Payment</a>

<form action="{{ route('invoices.send', $invoice) }}" method="POST" style="display:inline-block;">
    @csrf
    <button type="submit" class="btn btn-primary">Send Invoice Email</button>
</form>

@if($invoice->payments->count())
<h3>Payments:</h3>
<table class="table table-bordered">
    <thead>
        <tr><th>Date</th><th>Amount</th><th>Method</th></tr>
    </thead>
    <tbody>
    @foreach($invoice->payments as $payment)
        <tr>
            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
            <td>${{ number_format($payment->amount, 2) }}</td>
            <td>{{ $payment->payment_method }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
@section('scripts')
<script>
    