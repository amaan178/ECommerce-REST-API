<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials');
        $this->middleware('auth:api');
    }

    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching($category->id); // Sync the intermediate tables with a list of IDs without detaching.
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function destroy(Product $product, Category $category)
    {
        if(! $product->categories()->find($category->id)) {
            return $this->errorResponse('The product does not belong to the specified category!', 404);
        }
        $product->categories()->detach($category->id);
        $categories = $product->categories;
        return $this->showAll($categories);
    }
}
