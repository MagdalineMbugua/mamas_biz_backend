<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps =false;



    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }
    

    public function products()
    {
        return $this->hasOne(Product::class);
    }
}
