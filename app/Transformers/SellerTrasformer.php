<?php

namespace App\Transformers;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTrasformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier' => (int)$seller->id,
            'name' => $seller->name,
            'email' => $seller->email,
            'isVerified' => (bool)$seller->isVerified(),
            'creationDate' => $seller->created_at,
            'lastChangeDate' => $seller->updated_at,
            'deletionDate' => $seller->deleted_at ?? null,

            /* HATEOS Implementation */
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('sellers.show', $seller->id)
                ],
                [
                    'rel' => 'seller.category',
                    'href' => route('sellers.categories.index', $seller->id)
                ],
                [
                    'rel' => 'seller.products',
                    'href' => route('sellers.products.index', $seller->id)
                ],
                [
                    'rel' => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $seller->id)
                ],
                [
                    'rel' => 'seller.buyers',
                    'href' => route('sellers.buyers.index', $seller->id)
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $seller->id)
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
