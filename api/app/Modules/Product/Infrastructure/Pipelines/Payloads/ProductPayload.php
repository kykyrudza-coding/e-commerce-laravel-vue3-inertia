<?php

declare(strict_types=1);

namespace App\Modules\Product\Infrastructure\Pipelines\Payloads;

use App\Models\Product;
use App\Modules\Product\Application\Commands\CreateProductCommand;
use App\Modules\Product\Application\Commands\UpdateProductCommand;

final class ProductPayload
{
    public array $data;

    public ?Product $product = null;

    public function __construct(
        public readonly CreateProductCommand|UpdateProductCommand $command,
    ) {
        $this->data = $command instanceof CreateProductCommand
            ? [
                'category_id' => $command->categoryId,
                'name' => $command->name,
                'description' => $command->description,
                'price' => $command->price,
                'stock' => $command->stock,
                'slug' => $command->slug,
                'brand_id' => $command->brandId,
                'specifications' => $command->specifications,
            ]
            : $command->data;
    }

    public function identifier(): ?string
    {
        return $this->command instanceof UpdateProductCommand
            ? $this->command->identifier
            : null;
    }
}
