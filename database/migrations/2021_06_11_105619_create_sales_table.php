<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sales_id')-> primary();
            $table->id('user_id');
            $table->string('name');
            $table->string('phone_number');
            $table->enum('type', ['purchased', 'sold']);
            $table->enum('status', ['not_paid', 'not_fully_paid', 'paid']);
            $table->date('pay_at');
            $table->timestamps('created_at');
            $table->timestamp('updated_at')-> nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
