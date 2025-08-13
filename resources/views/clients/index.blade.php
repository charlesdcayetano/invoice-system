@extends('layouts.layout')
@section('title', 'Clients')
@section('styles')

@section('content')
<h1>Clients</h1>

<a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Add New Client</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->address }}</td>
            <td>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this client?')" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
@section('scripts')
{{ $products->links() }}

<script>