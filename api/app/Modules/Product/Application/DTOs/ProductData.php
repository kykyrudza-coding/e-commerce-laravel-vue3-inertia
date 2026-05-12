<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\DTOs;

use App\Models\Product;
use App\Models\Review;

final readonly class ProductData
{
    public function __construct(
        private Product $product,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self($product);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->product->id,
            'category_id' => $this->product->category_id,
            'name' => $this->product->name,
            'description' => $this->product->description,
            'price' => (float) $this->product->price,
            'stock' => $this->product->stock,
            'slug' => $this->product->slug,
            'specifications' => $this->product->specifications ?? [],
            'category' => $this->relation('category'),
            'images' => $this->relation('images'),
            'main_image' => $this->relation('main_image'),
            'brand' => $this->relation('brand'),
            'reviews' => $this->reviews(),
        ];
    }

    private function relation(string $relation): mixed
    {
        return $this->product->relationLoaded($relation)
            ? $this->product->getRelation($relation)
            : null;
    }

    private function reviews(): ?array
    {
        if (! $this->product->relationLoaded('reviews')) {
            return null;
        }

        return $this->product->reviews
            ->map(fn (Review $review): array => ReviewData::fromModel($review)->toArray())
            ->all();
    }
}
