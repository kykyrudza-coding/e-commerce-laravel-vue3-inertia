<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Commands;

final readonly class CreateProductCommand
{
    public function __construct(
        public int $categoryId,
        public string $name,
        public string $description,
        public float $price,
        public ?int $stock,
        public ?string $slug,
        public ?int $brandId,
        public array $specifications,
    ) {}
}
