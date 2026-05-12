<?php

declare(strict_types=1);

namespace App\Modules\Product\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Models\Product;
use App\Modules\Product\Application\Commands\UpdateProductCommand;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $productId = $this->currentProductId();

        return [
            'category_id' => ['sometimes', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:255', Rule::unique('products', 'name')->ignore($productId)],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'slug' => ['sometimes', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
            'brand_id' => ['sometimes', 'nullable', 'exists:brands,id'],
            'specifications' => ['sometimes', 'nullable', 'array'],
            'specifications.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function toCommand(): UpdateProductCommand
    {
        return new UpdateProductCommand(
            identifier: (string) $this->route('product'),
            data: $this->validated(),
        );
    }

    private function currentProductId(): ?int
    {
        $identifier = (string) $this->route('product');

        return Product::query()
            ->where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->value('id');
    }
}
