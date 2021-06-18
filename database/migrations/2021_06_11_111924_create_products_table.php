<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id ('product_id');
            $table->string('product_name');
            $table->decimal('price');
            $table-> enum('product_type', ['meat_product', 'cattle']);
            
        });

        Schema::create('sale__products',function (Blueprint $table) {
            $table->unsignedBigInteger('sales_id');
            $table->decimal('price');
            $table->decimal('quantity');
            $table->foreign('sales_id')-> references('sales_id')-> on('sales')->cascadeOnUpdate();
            $table->unsignedBigInteger ('product_id');
            $table->foreign('product_id')->references('product_id') -> on('products') ->cascadeOnUpdate();

        }

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
