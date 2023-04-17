<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticable implements MustVerifyEmail
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $guarded = [];

    protected $hidden = [
        'password'
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sales::class, 'created_by');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }
}
