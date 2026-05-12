<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\QueryHandlers;

use App\Modules\Product\Application\Queries\SearchProductsQuery;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Collection;

final readonly class SearchProductsHandler
{
    public function __construct(
        private ProductRepositoryInterface $products,
    ) {}

    public function handle(SearchProductsQuery $query): Collection
    {
        return $this->products->search($query->term);
    }
}
