<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTrasformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'identifier' => (int)$category->id,
            'title' => $category->name,
            'details' => $category->description,
            'creationDate' => $category->created_at,
            'lastChangeDate' => $category->updated_at,
            'deletionDate' => $category->deleted_at ?? null,

            /* HATEOS Implementation */
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $category->id)
                ],
                [
                    'rel' => 'category.buyers',
                    'href' => route('categories.buyers.index', $category->id)
                ],
                [
                    'rel' => 'category.sellers',
                    'href' => route('categories.sellers.index', $category->id)
                ],
                [
                    'rel' => 'category.products',
                    'href' => route('categories.products.index', $category->id)
                ],
                [
                    'rel' => 'category.transactions',
                    'href' => route('categories.transactions.index', $category->id)
                ],
            ],
        ];
    }

    public static function getOriginalAttribute(string $transformedAttribute)
    {
        $attribute = [
            'identifier' => 'id',
            'title' => 'name',
            'details' => 'description',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at' ?? null,
        ];

        return $attribute[$transformedAttribute] ?? null;
    }

    public static function getTransformedAttribute(string $originalAttribute)
    {
        $attribute = [
            'id' => 'identifier',
            'name' => 'title',
            'description' => 'details',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChangeDate',
            'deleted_at' => 'deletionDate',
        ];

        return $attribute[$originalAttribute] ?? null;
    }
}
