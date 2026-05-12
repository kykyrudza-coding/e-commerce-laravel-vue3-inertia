<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\DTOs;

use App\Models\Product;

final readonly class ProductDetailsData
{
    public function __construct(
        private Product $product,
        private array $characteristics,
        private string $domain,
    ) {}

    public function data(): array
    {
        return ProductData::fromModel($this->product)->toArray();
    }

    public function meta(): array
    {
        return [
            'characteristics' => $this->characteristics,
            'domain' => $this->domain,
        ];
    }
}
