<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale__products', function (Blueprint $table) {
            $table->foreignId('sales_id')-> references('sales_id')-> on('sales');
            $table->id('product_id')-> references('product_id')-> on('products');
            $table->decimal('price');
            $table->decimal('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale__products');
    }
}
