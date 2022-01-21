<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Sale_Product extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "sales__products";
}
