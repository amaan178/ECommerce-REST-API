<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionsController extends ApiController
{

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
