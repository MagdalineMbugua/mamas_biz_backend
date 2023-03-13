<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticable
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $guarded = [];

    protected $hidden = [
        'password'
    ];

    public function sales()
    {
        return $this->hasMany(Sales::class, 'created_by');
    }
}
