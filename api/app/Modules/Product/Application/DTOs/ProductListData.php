<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\DTOs;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class ProductListData
{
    public function __construct(
        private LengthAwarePaginator $products,
        private array $filters,
        private string $domain,
    ) {}

    public function data(): array
    {
        return collect($this->products->items())
            ->map(fn ($product): array => ProductData::fromModel($product)->toArray())
            ->all();
    }

    public function meta(): array
    {
        return [
            'total' => $this->products->total(),
            'per_page' => $this->products->perPage(),
            'current_page' => $this->products->currentPage(),
            'last_page' => $this->products->lastPage(),
            'from' => $this->products->firstItem(),
            'to' => $this->products->lastItem(),
            'filters' => $this->filters,
            'domain' => $this->domain,
        ];
    }
}
