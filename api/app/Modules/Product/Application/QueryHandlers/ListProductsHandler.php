<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\QueryHandlers;

use App\Modules\Product\Application\DTOs\ProductListData;
use App\Modules\Product\Application\Queries\ListProductsQuery;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;

final readonly class ListProductsHandler
{
    public function __construct(
        private ProductRepositoryInterface $products,
    ) {}

    public function handle(ListProductsQuery $query): ProductListData
    {
        return new ProductListData(
            products: $this->products->paginate($query),
            filters: $this->products->filters(),
            domain: (string) config('app.url'),
        );
    }
}
