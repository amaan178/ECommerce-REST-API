<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()
            ->with('product')
            ->get()
            ->pluck('product');

        return $this->showAll($products);
    }
}
