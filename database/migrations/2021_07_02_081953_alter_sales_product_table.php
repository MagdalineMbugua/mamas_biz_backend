<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterSalesProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale__products', function (Blueprint $table) {
            
            $table->dropForeign(['sales_id']);
            $table->dropForeign(['product_id']);
            $table->primary(['product_id', 'sales_id']);
           
           
        });
    }

    
    
}
