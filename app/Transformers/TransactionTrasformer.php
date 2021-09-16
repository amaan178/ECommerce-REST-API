<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTrasformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => $transaction->quantity,
            'buyer' => (int)$transaction->buyer_id,
            'product' => (int)$transaction->product_id,
            'creationDate' => $transaction->created_at,
            'lastChangeDate' => $transaction->updated_at,
            'deletionDate' => $transaction->deleted_at ?? null,

            /* HATEOS Implementation */
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $transaction->id)
                ],
                [
                    'rel' => 'buyers',
                    'href' => route('buyers.index', $transaction->buyer_id)
                ],
                [
                    'rel' => 'transaction.sellers',
                    'href' => route('transactions.sellers.index', $transaction->id)
                ],
                [
                    'rel' => 'transaction.categories',
                    'href' => route('transactions.categories.index', $transaction->id)
                ],
                [
                    'rel' => 'product',
                    'href' => route('products.show', $transaction->product_id)
                ],
            ],
        ];
    }

    public static function getOriginalAttribute(string $transformedAttribute)
    {
        $attribute = [
            'identifier' => 'id',
            'stock' => 'quantiy',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
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
            'quantiy' => 'stock',
            'buyer_id' => 'buyer',
            'product_id' => 'product',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChangeDate',
            'deleted_at' => 'deletionDate',
        ];
        return $attribute[$originalAttribute] ?? null;
    }
}
