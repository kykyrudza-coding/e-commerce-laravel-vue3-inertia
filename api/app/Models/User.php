<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
