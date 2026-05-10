<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'slug',
        'brand_id',
        'specifications',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'specifications' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function main_image(): HasOne
    {
        return $this->mainImage();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public static function mostSoldInStore(int $limit = 5): Collection
    {
        return self::query()
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('product_images', function ($join): void {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.is_main', true);
            })
            ->where('orders.status', 'paid')
            ->selectRaw('
                products.id,
                products.name,
                products.slug,
                products.price,
                product_images.image_path as image,
                SUM(order_items.quantity) as total_sold
            ')
            ->groupBy(
                'products.id',
                'products.name',
                'products.slug',
                'products.price',
                'product_images.image_path'
            )
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public static function mostSoldInRegion(string $region, int $limit = 10): Collection
    {
        return self::query()
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('delivery_address', 'orders.id', '=', 'delivery_address.order_id')
            ->leftJoin('product_images', function ($join): void {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.is_main', true);
            })
            ->where('delivery_address.region', $region)
            ->where('orders.status', 'paid')
            ->selectRaw('
                products.id,
                products.name,
                products.slug,
                products.price,
                product_images.image_path as image,
                SUM(order_items.quantity) as total_sold
            ')
            ->groupBy(
                'products.id',
                'products.name',
                'products.slug',
                'products.price',
                'product_images.image_path'
            )
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
}
