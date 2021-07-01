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
            $table->id('sales_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('phone_number');
            $table->enum('type', ['purchased', 'sold']);
            $table->enum('status', ['not_paid', 'not_fully_paid', 'paid']);
            $table->date('pay_at');
            $table->timestamps();

            $table->foreign('user_id')-> references('user_id') -> on('users')->cascadeOnUpdate();
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
