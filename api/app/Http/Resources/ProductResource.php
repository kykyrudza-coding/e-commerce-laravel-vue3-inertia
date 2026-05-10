<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'stock' => $this->stock,
            'slug' => $this->slug,
            'specifications' => $this->specifications ?? [],
            'category' => new CategoryResource($this->whenLoaded('category')),
            'images' => $this->whenLoaded('images'),
            'main_image' => $this->whenLoaded('main_image'),
            'brand' => $this->whenLoaded('brand'),
            'reviews' => $this->whenLoaded('reviews', fn () => $this->reviews->map(fn ($review) => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->review,
                'review' => $review->review,
                'user' => $review->relationLoaded('user') ? $review->user : null,
                'created_at' => $review->created_at,
            ])),
        ];
    }
}
