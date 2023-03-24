<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SaleProduct extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "sales_products";
}
