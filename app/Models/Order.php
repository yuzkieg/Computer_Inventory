<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['supplier_id', 'product_id', 'product_name', 'quantity', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function product()
{
    return $this->belongsTo(Product::class);
}

}