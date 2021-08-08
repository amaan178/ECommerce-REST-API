<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellersController extends Controller
{

    public function index()
    {
        $seller = Seller::has('products')->get();
        return response()->json(['count' => $seller->count(), 'data' => $seller], 200);
    }


    public function show($id)
    {
        $seller = Seller::has('products')->finOrFail($id);
        return response()->json(['data' => $seller], 200);
    }

}
