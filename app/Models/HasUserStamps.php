<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait HasUserStamps
{
    protected static function bootHasUserStamps()
    {
        if (Auth::check()) {
            static::creating(function ($model) {
                $model->created_by = Auth::id();
            });

            static::updating(function ($model) {
                $model->updated_by = Auth::id();
            });
        }
    }

    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
