<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    use HasFactory;

    protected $table = 'users';

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
