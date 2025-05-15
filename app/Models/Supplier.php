<?php

// app/Models/Supplier.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'supplier_no',
        'location',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplier_id', 'id');
    }
    public function orders()
{
    return $this->hasMany(Order::class);
}
}