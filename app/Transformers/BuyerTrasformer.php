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

            /* HATEOS Implementation */
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id)
                ],
                [
                    'rel' => 'buyer.category',
                    'href' => route('buyers.categories.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyers.sellers.index', $buyer->seller_id)
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('buyers.products.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id)
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $buyer->id)
                ],
            ],
        ];
    }

    public static function getOriginalAttribute(string $transformedAttribute)
    {
        $attribute = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at',
        ];

        return $attribute[$transformedAttribute] ?? null;
    }

    public static function getTransformedAttribute(string $originalAttribute)
    {
        $attribute = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChangeDate',
            'deleted_at' => 'deletionDate',
        ];

        return $attribute[$originalAttribute] ?? null;
    }
}
