<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
       $transformedCollection = $this->transformData($collection, $transformer);
        return $this->successResponse(['count' => $collection->count(), 'data' => $transformedCollection["data"]], $code);
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
}
