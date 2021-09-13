<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use App\Transformers\BuyerTrasformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    use HasFactory;

    protected $table = 'users';

    public string $transformer = BuyerTrasformer::class;

    public function __construct()
    {
        array_push($this->hidden, 'admin');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope());
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
