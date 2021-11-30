<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $products =
    [
        'watches' => 200,
        't-shirts' => 50,
        'cameras' => 250,
        'mobiles' => 400,
    ];
    public function index()
    {
        return $this->products;
    }
    public function show($name)
    {
        return $this->products[$name] ?? 'Not Found! ';
    }
}
