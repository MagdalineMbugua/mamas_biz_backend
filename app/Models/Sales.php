<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Database\Factories\SalesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    use Filterable;
    use HasUserStamps;

    protected $guarded = [];
    protected $cast = [
        'created_by' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'sale__products');
    }

    protected static function newFactory()
    {
        return SalesFactory::new();
    }
}
