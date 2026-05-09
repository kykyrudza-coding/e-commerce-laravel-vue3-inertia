<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryAddress extends Model
{
    protected $table = 'delivery_address';

    protected $fillable = [
        'order_id',
        'city',
        'region',
        'street',
        'house',
        'post_office',
        'postal_code',
        'date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
