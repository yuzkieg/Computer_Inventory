<?php

// database/migrations/XXXX_XX_XX_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id'); // Add product_id column
            $table->string('product_name'); // Optional if you prefer to store product name directly
            $table->integer('quantity');
            $table->enum('status', ['pending', 'received'])->default('pending');
            $table->timestamps();

            // Foreign key constraint for product_id
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}