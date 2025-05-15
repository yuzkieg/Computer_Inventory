<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_reports', function (Blueprint $table) {
            $table->id();
            $table->boolean('reorder')->default(false); // For Reorder status
            $table->string('item_no');
            $table->string('product_name');
            $table->string('supplier');
            $table->decimal('cost_per_item', 10, 2);
            $table->integer('stock_quantity');
            $table->decimal('inventory_value', 12, 2);
            $table->integer('item_reorder_quantity');            $table->boolean('item_discontinued')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_reports');
    }
}