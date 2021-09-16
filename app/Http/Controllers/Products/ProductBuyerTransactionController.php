<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\Transaction;
use App\Transformers\TransactionTrasformer;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . TransactionTrasformer::class)->only('store');
    }

    public function store(Request $request, Product $product, Buyer $buyer)
    {
        $rules = [
            'quantity' => 'required|min:1|integer',
        ];
        $this->validate($request, $rules);

        if($buyer->id === $product->seller_id) {
            return $this->errorResponse('Buyer and Seller cannot be same!', 409);
        }

        if(! $buyer->isVerified()) {
            return $this->errorResponse('Buyer should be verified', 409);
        }

        if(! $product->seller->isVerified()) {
            return $this->errorResponse('Seller should be verified', 409);
        }

        if(! $product->isAvailable()) {
            return $this->errorResponse('Product is unavailable!', 409);
        }

        if($product->quantity < $request->quantity) {
            return $this->errorResponse('Product does not have enough inventory to fulfill your order!!', 409);
        }

        return DB::transaction(function () use($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);
            return $this->showOne($transaction);
        });
    }
}
