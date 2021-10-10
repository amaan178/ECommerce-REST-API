<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;

class TransactionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('scope:read-general')->only('show');
    }

    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }


}
