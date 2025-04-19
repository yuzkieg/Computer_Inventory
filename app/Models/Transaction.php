<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'item_name',
        'quantity',
        'price_each',
        'total_price',
    ];
}
