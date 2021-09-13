<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTrasformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier' => (int)$product->id,
            'title' => $product->name,
            'details' => $product->description,
            'stock' => (int)$product->quantity,
            'status' => (string)$product->status,
            'picture' => url("img/{$product->image}"),
            'seller' => $product->seller_id,
            'creationDate' => $product->created_at,
            'lastChangeDate' => $product->updated_at,
            'deletionDate' => $product->deleted_at ?? null,
        ];
    }
}
