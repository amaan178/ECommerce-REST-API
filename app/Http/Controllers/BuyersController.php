<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return $this->showAll($buyers);
    }
    public function show($id)
    {
        $buyer = Buyer::has('transactions')->findOrFail($id);
        return $this->showOne($buyer);
    }
}
