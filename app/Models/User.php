<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $hidden = [
        'password'
    ];

    public function sales()
    {
        return $this->hasMany(Sales::class, 'created_by');
    }
}
