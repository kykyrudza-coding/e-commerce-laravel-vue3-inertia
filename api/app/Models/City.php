<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $table = 'city';

    protected $fillable = [
        'name',
    ];

    public function region(): HasMany
    {
        return $this->hasMany(Region::class);
    }

    public function postOffices(): HasMany
    {
        return $this->hasMany(PostOffice::class);
    }
}

