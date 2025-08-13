@extends('layouts.layout')


@section('content')
<h1>Add Client</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('clients.store') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea name="address" id="address" class="form-control">{{ old('address') }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Save Client</button>
</form>

<form method="GET" action="{{ route('products.index') }}" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products" class="border p-2 rounded" />
    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Search</button>
</form>

{{ $products->links() }}

@endsection
