<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice System</title>
    @vite('resources/css/app.css') <!-- Breeze uses Vite for assets -->
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow mb-6">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div>
                <a href="{{ route('products.index') }}" class="text-blue-600 font-semibold mr-4 hover:underline">Products</a>
                <a href="{{ route('clients.index') }}" class="text-blue-600 font-semibold mr-4 hover:underline">Clients</a>
                <a href="{{ route('invoices.index') }}" class="text-blue-600 font-semibold hover:underline">Invoices</a>
            </div>
            <div>
                @auth
                <span class="mr-4">Hi, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline mr-4">Login</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4">
        @yield('content')
    </main>
</body>
</html>
{{ $products->links() }}

@extends('layouts.app')
