<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostOffice extends Model
{
    protected $table = 'post_office';

    protected $fillable = [
        'name',
        'address',
        'city_id',
        'region_id',
    ];

    public function city(): HasOne
    {
        return $this->hasOne(City::class);
    }

    public function region(): HasOne
    {
        return $this->hasOne(Region::class);
    }
}

