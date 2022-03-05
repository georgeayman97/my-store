<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    
    public function index(Request $request)
    {
        return Product::paginate();
    }
    public function show($id)
    {
        $products = Product::findOrFail($id);
        return $products;
    }
}
