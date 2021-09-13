<?php

namespace App\Transformers;

use App\Models\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTrasformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int)$buyer->id,
            'name' => $buyer->name,
            'email' => $buyer->email,
            'isVerified' => (bool)$buyer->isVerified(),
            'creationDate' => $buyer->created_at,
            'lastChangeDate' => $buyer->updated_at,
            'deletionDate' => $buyer->deleted_at ?? null,
        ];
    }
}
