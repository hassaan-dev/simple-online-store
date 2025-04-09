<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function apiIndex(): JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
