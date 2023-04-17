<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Http\Filters\Filterable;
use Database\Factories\ProductFactory;
use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;
    use Searchable;
    protected $guarded = [];

    public function sales():BelongsToMany
    {
        return $this->belongsToMany(Sales::class, 'sales_products')
            ->withPivot(['quantity', 'price'])
            ->using(SaleProduct::class);
    }

    public static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function toSearchableArray(): array
    {
        return $this->toArray();
    }

    public function shouldBeSearchable(): bool
    {
        return count($this->toSearchableArray()) > 0;
    }
}
