<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductTransactionController extends ApiController
{
    public function index(Product $product)
    {
        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }
}
