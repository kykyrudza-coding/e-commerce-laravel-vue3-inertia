<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'image_path',
        'is_main',
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function getImagePathAttribute(): string
    {
        return $this->attributes['image_path'];
    }
    public function getIsMainAttribute(): bool
    {
        return $this->attributes['is_main'];
    }
}
