<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_Product extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }
    

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
