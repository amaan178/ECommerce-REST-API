<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ResponseHelper
{
    private function successResponse(mixed $data, int $code)
    {
        return response()->json($data, $code);
    }

    protected function reportMultipleErrors(mixed $message, int $code)
    {
        return response()->json(['error' => $message, 'code' =>$code], $code);
    }

    protected function errorResponse(string $message, int $code)
    {
        return response()->json(['error' => $message, 'code' =>$code], $code);
    }

    protected function showAll(Collection $collection, int $code = 200)
    {
       if($collection->isEmpty())
       {
           return $this->successResponse(['count' => 0, 'data' => $collection], $code);
       }
       $transformer = $collection->first()->transformer;
       $collection = $this->sort($collection, $transformer);
       $collection = $this->filter($collection, $transformer);
       $collection = $this->paginate($collection);
       $transformedCollection = $this->transformData($collection, $transformer);

       $transformedCollection['count'] = $collection->count();
        return $this->successResponse($transformedCollection, $code);
    }

    protected function showOne(Model $model, int $code=200)
    {
        $transformer = $model->transformer;
        $transformedData = $this->transformData($model, $transformer);
        return $this->successResponse($transformedData, $code);
    }

    protected function showMessage(string $message, int $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformData($data, string $transformer){
        $transformedData = fractal($data, new $transformer);
        return $transformedData->toArray();
    }

    private function sort(Collection $collection, string $transformer)
    {
        if(request()->has('sort_by')) {
            $transformedAttribute = request()->sort_by;
            $sortByAttribute = $transformer::getOriginalAttribute($transformedAttribute);
            $collection = $collection->sortBy($sortByAttribute);
        }
        return $collection;
    }

    private function filter(Collection $collection, string $transformer)
    {
        foreach(request()->query() as $filterBy => $value) {
            if($this->isFilterableAttribute($filterBy)) {
                $actualAttribute = $transformer::getOriginalAttribute($filterBy);
                if(isset($actualAttribute, $value)) {
                    $collection = $collection->where($actualAttribute, $value);
                }
            }
        }
        return $collection;
    }

    private function isFilterableAttribute(string $attribute):bool {
        return ! in_array($attribute, ['sort_by', 'per_page']);
    }

    private function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:10|max:100',
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $elementsPerPage = 15;

        if(request()->has('per_page')) {
            $elementsPerPage = (int)request()->per_page;
        }
        $results = $collection->slice($elementsPerPage * ($page-1), $elementsPerPage);
        $paginator = new LengthAwarePaginator($results, $collection->count(), $elementsPerPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginator->appends(request()->all());
        return $paginator;
    }
}
