@extends('layouts.app')

@section('content')
<h1>Products</h1>
<form method="POST" action="{{ route('products.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Product Name">
    <input type="number" name="price" placeholder="Price">
    <input type="number" name="stock" placeholder="Stock">
    <button type="submit">Add Product</button>
</form>

<table>
<tr>
    <th>Name</th><th>Price</th><th>Stock</th>
</tr>
@foreach($products as $product)
<tr>
    <td>{{ $product->name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
</tr>
@endforeach
</table>
@endsection

@extends('layouts.app')