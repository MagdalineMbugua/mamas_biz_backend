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
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->enum('product_type', ['meat_product', 'livestock']);
            $table->string('uom');
            $table->timestamps();
        });

        Schema::create(
            'sales_products',
            function (Blueprint $table) {
                $table->unsignedBigInteger('sales_id');
                $table->decimal('price');
                $table->decimal('quantity');
                $table->unsignedBigInteger('product_id');

                $table->foreign('sales_id')
                    ->references('id')
                    ->on('sales')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

                $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            }

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('sales_products');
    }
}
