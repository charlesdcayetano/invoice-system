<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
   public function destroy($id)
    {
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    Product::create($validated);

    return redirect()->back()->with('success', 'Product added successfully.');
}

}
