<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'slug',
        'brand_id',
        'screen_size_id',
        'screen_type_id',
        'os_id',
        'processor_id',
        'ram_id',
        'storage_id',
        'camera_resolution_id',
        'battery_capacity_id',
        'color_id',
        'condition_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images():HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function main_image(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function screenType(): BelongsTo
    {
        return $this->belongsTo(ScreenType::class);
    }

    public function operatingSystem(): BelongsTo
    {
        return $this->belongsTo(OperatingSystem::class, 'os_id');
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(Processor::class);
    }

    public function battery_capacity(): BelongsTo
    {
        return $this->belongsTo(BatteryCapacity::class);
    }

    public function camera_resolution(): BelongsTo
    {
        return $this->belongsTo(CameraResolution::class);
    }

    public function storage(): BelongsTo
    {
        return $this->belongsTo(Storage::class);
    }

    public function ram(): BelongsTo
    {
        return $this->belongsTo(Ram::class);
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }

    public function review(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public static function most_sold_in_store($limit = 5)
    {
        return self::select('products.id', 'products.name', 'products.slug', 'products.price')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.is_main', true);
            })
            ->where('orders.status', 'paid')
            ->selectRaw('products.id, products.name, products.price, product_images.image_path as image, COUNT(order_items.product_id) as total_sold')
            ->groupBy('products.id', 'products.name', 'products.slug', 'products.price', 'product_images.image_path') 
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
    public static function most_sold_in_region($region, $limit = 10)
    {
        return self::select('products.id', 'products.name', 'products.slug', 'products.price')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.is_main', true);
            })
            ->join('delivery_address', 'orders.id', '=', 'delivery_address.order_id')
            ->where('delivery_address.region', $region)
            ->where('orders.status', 'paid')
            ->selectRaw('products.id, products.name, products.price, product_images.image_path as image, COUNT(order_items.product_id) as total_sold')
            ->groupBy('products.id', 'products.name', 'products.slug', 'products.price', 'product_images.image_path')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
}
