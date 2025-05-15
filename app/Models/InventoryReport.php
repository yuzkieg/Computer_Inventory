<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryReport extends Model
{
    protected $table = 'inventory_reports';

    protected $fillable = [
        'reorder',
        'item_no',
        'product_name',
        'supplier',
        'cost_per_item',
        'stock_quantity',
        'inventory_value',
        'item_reorder_quantity',
        'item_discontinued',
    ];
}