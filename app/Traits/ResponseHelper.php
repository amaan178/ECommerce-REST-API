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

    protected function errorResponse(string $message, int $code)
    {
        return response()->json(['error' => $message, 'code' =>$code], $code);
    }

    protected function showAll(Collection $collection, int $code = 200)
    {
        return $this->successResponse(['count' => $collection->count(), 'data' => $collection], $code);
    }

    protected function showOne(Model $model, int $code=200)
    {
        return $this->successResponse(['data'=>$model], $code);
    }
}
