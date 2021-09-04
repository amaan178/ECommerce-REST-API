<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryTransactionController extends ApiController
{
    public function index(Category $category)
    {
        $transactions = $category->products()
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->flatten();

        return $this->showAll($transactions);
    }
}
