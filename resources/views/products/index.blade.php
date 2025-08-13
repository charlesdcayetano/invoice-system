@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Products</h1>

<form method="GET" action="{{ route('products.index') }}" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products" class="border p-2 rounded" />
    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Search</button>
</form>


<form method="POST" action="{{ route('products.store') }}" class="mb-6 max-w-md">
    @csrf
    <input type="text" name="name" placeholder="Product Name" class="border p-2 rounded w-full mb-2" required />
    <input type="number" name="price" placeholder="Price" class="border p-2 rounded w-full mb-2" required />
    <input type="number" name="stock" placeholder="Stock" class="border p-2 rounded w-full mb-2" required />
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Product</button>
</form>

<table class="w-full table-auto border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-300 p-2 text-left">Name</th>
            <th class="border border-gray-300 p-2 text-left">Price</th>
            <th class="border border-gray-300 p-2 text-left">Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr class="hover:bg-gray-100">
            <td class="border border-gray-300 p-2">{{ $product->name }}</td>
            <td class="border border-gray-300 p-2">${{ number_format($product->price, 2) }}</td>
            <td class="border border-gray-300 p-2">{{ $product->stock }}</td>
        </tr>

                @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @endforeach
    </tbody>
</table>
{{ $products->links() }}

@endsection
