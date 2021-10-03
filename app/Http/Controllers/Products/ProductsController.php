<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only('index', 'show');
        $this->middleware('auth:api');
    }

    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }


    public function show(Product $product)
    {
        return $this->showOne($product);
    }

}
