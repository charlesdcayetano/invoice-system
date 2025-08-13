<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
    $products = Product::paginate(10); // 10 per page
    return view('products.index', compact('products'));
    }



public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer'
    ]);

    Product::create($request->all());
    return redirect()->back()->with('success', 'Product added successfully');
}

}

