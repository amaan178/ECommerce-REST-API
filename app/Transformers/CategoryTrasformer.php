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
        ];
    }

    public static function getOriginalAttribute(string $transformedAttribute)
    {
        $attribute = [
            'identifier' => 'id',
            'name' => 'name',
            'details' => 'description',
            'creationDate' => 'created_at',
            'lastChangeDate' => 'updated_at',
            'deletionDate' => 'deleted_at' ?? null,
        ];

        return $attribute[$transformedAttribute] ?? null;
    }
}