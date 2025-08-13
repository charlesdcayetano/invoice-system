<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product resource routes
    Route::resource('products', ProductController::class);

    // Client resource routes
    Route::resource('clients', ClientController::class);

    // Invoice resource routes
    Route::resource('invoices', InvoiceController::class);

    // Special invoice routes
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');

    // Invoice item routes (for adding/updating/removing items)
    Route::post('invoices/{invoice}/items', [InvoiceController::class, 'addItem'])->name('invoices.items.add');
    Route::put('invoices/{invoice}/items/{item}', [InvoiceController::class, 'updateItem'])->name('invoices.items.update');
    Route::delete('invoices/{invoice}/items/{item}', [InvoiceController::class, 'removeItem'])->name('invoices.items.remove');
    Route::post('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])->name('invoices.markPaid');

    // Payment resource routes
    Route::resource('payments', PaymentController::class);

    // Payment creation tied to invoices
    Route::get('payments/create/{invoice}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');

    // Client-specific relations
    Route::get('clients/{client}/invoices', [ClientController::class, 'invoices'])->name('clients.invoices');
    Route::get('clients/{client}/payments', [ClientController::class, 'payments'])->name('clients.payments');

    // Product-specific relations
    Route::get('products/{product}/invoices', [ProductController::class, 'invoices'])->name('products.invoices');
    Route::get('products/{product}/clients', [ProductController::class, 'clients'])->name('products.clients');
});

// Admin routes, protected by both 'auth' and 'admin' middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';
