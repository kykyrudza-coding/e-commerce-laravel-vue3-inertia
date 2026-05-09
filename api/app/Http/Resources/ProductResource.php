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
            'category' => new CategoryResource($this->whenLoaded('category')),
            'images' => $this->whenLoaded('images'),
            'main_image' => $this->whenLoaded('main_image'),
            'brand' => $this->whenLoaded('brand'),
            'screen_type' => $this->whenLoaded('screenType'),
            'operating_system' => $this->whenLoaded('operatingSystem'),
            'processor' => $this->whenLoaded('processor'),
            'ram' => $this->whenLoaded('ram'),
            'storage' => $this->whenLoaded('storage'),
            'camera_resolution' => $this->whenLoaded('camera_resolution'),
            'battery_capacity' => $this->whenLoaded('battery_capacity'),
            'color' => $this->whenLoaded('color'),
            'condition' => $this->whenLoaded('condition'),
            'reviews' => $this->whenLoaded('review'),
        ];
    }
}
