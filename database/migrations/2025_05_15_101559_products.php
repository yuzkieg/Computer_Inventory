<?php
// database/migrations/your_migration_file.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('serial_number')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->string('product_lifespan')->nullable(); // New column
            $table->string('supplier_warranty')->nullable(); // New column
            $table->timestamps();
    
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}