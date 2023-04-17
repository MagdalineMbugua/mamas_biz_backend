<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use App\Http\Filters\Filterable;
use App\Models\QueryBuilders\SalesQueryBuilder;
use Database\Factories\SalesFactory;
use Elastic\ScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    use HasFactory;
    use HasUserStamps;
    use EagerLoadPivotTrait;
    use Searchable;
    use Filterable;

    protected $guarded = [];
    protected array $cast = [
        'created_by' => 'integer',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sales_products')
            ->withPivot(['quantity', 'price'])
            ->using(SaleProduct::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    protected static function newFactory(): SalesFactory
    {
        return SalesFactory::new();
    }

    public function newEloquentBuilder($query): SalesQueryBuilder
    {
        return new SalesQueryBuilder($query);
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
