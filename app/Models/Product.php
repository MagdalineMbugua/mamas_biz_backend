<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sales()
    {
        return $this->belongsToMany(Sales::class, 'sales__products')
            ->withPivot(['quantity', 'price'])
            ->using(Sale_Product::class);;
    }
}
