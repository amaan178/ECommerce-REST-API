<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
    public function index(Product $product)
    {
        $buyers = $product->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique('id');
        return $this->showAll($buyers);
    }
}
