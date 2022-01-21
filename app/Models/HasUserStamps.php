<?php

namespace App\Models;

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
}
