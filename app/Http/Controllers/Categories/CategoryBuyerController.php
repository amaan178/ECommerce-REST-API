<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryBuyerController extends ApiController
{
    public function index(Category $category)
    {
        $buyers = $category->products()
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->flatten()
            ->pluck('buyer')
            ->unique()
            ->values();

        return $this->showAll($buyers);
    }
}
