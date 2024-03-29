<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = [];

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }

    public static function newFactory(): PaymentFactory
    {
        return PaymentFactory::new();
    }

}
