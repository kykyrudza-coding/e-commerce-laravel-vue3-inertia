<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Region extends Model
{
    protected $table = 'region';

    protected $fillable = [
        'name',
        'city_id',
    ];

    public function cities(): HasOne
    {
        return $this->hasOne(City::class);
    }

    public function postOffices(): HasMany
    {
        return $this->hasMany(PostOffice::class);
    }
}
