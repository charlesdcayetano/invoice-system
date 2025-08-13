<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\PaymentController; 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::resource('products', ProductController::class);
// Route::resource('invoices', InvoiceController::class);
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('clients.index');
});

Route::resource('clients', ClientController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('invoice-items', InvoiceItemController::class);
Route::resource('payments', PaymentController::class);
Route::resource('payments', PaymentController::class)->only(['create', 'store']);
Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');

