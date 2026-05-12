<?php

declare(strict_types=1);

namespace App\Modules\Product\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\Product\Application\Commands\CreateProductCommand;

class StoreProductRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'specifications' => ['nullable', 'array'],
            'specifications.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function toCommand(): CreateProductCommand
    {
        $data = $this->validated();

        return new CreateProductCommand(
            categoryId: (int) $data['category_id'],
            name: $data['name'],
            description: $data['description'],
            price: (float) $data['price'],
            stock: isset($data['stock']) ? (int) $data['stock'] : null,
            slug: $data['slug'] ?? null,
            brandId: isset($data['brand_id']) ? (int) $data['brand_id'] : null,
            specifications: $data['specifications'] ?? [],
        );
    }
}
