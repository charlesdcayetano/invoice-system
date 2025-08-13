<script>
function addRow() {
    let table = document.getElementById('invoiceItems');
    let row = table.insertRow();
    row.innerHTML = `
        <td>
            <select name="product_id[]" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="quantity[]" required></td>
        <td><input type="number" name="price[]" step="0.01" required></td>
        <td><input type="number" name="total[]" step="0.01" readonly></td>
        <td><button type="button" onclick="this.parentElement.parentElement.remove()">X</button></td>
    `;
}
</script>

<script>
document.addEventListener('input', function(e) {
    if (e.target.name === 'quantity[]' || e.target.name === 'price[]') {
        let row = e.target.closest('tr');
        let qty = parseFloat(row.querySelector('[name="quantity[]"]').value) || 0;
        let price = parseFloat(row.querySelector('[name="price[]"]').value) || 0;
        row.querySelector('[name="total[]"]').value = (qty * price).toFixed(2);
    }
});
</script>

@extends('layouts.app')