<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return response()->json(['count' => $buyers->count(), 'data' => $buyers], 200);
    }
    public function show($id)
    {
        $buyers = Buyer::has('transactions')->findOrFail($id);
        return response()->json(['data' => $buyers], 200);
    }
}
