<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ];

        $this->validate($request, $rules);
        $data = $request->all();

        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = '1.jpg'; // TODO: Image upload is left..
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);
        return $this->showOne($product);

    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $this->verifySeller($seller, $product);

        $rules = [
            'name' => 'min:1',
            'description' => 'min:5',
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::AVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT,
            'image' => 'image'
        ];

        $this->validate($request, $rules);

        $product->fill(
            $request->only([
                'name',
                'description',
                'quantity'
            ])
        );

        if($request->has('status')) {
            $product->status = $request->status;

            if($product->isAvailable() && $product->categories()->count() ==0) {
                return $this->errorResponse("A product must be associated with atleast one category to be Available!", 409);
            }
        }

        // TODO: Image Update needs to Handled!

        if($product->isClean()) {
            return $this->errorResposne("You have not updated any value!!", 422);
        }

        $product->save();
        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->verifySeller($seller, $product);
        $product->delete();
        return $this->showOne($product);
    }

    private function verifySeller(Seller $seller, Product $product)
    {
        if($seller->id != $product->seller_id) {
            throw new HttpException(422, "You are trying to update someone else's product!");
        }
    }
}
