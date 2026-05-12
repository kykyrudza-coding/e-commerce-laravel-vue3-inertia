<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\QueryHandlers;

use App\Modules\Product\Application\DTOs\ProductDetailsData;
use App\Modules\Product\Application\Queries\ShowProductQuery;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;

final readonly class ShowProductHandler
{
    public function __construct(
        private ProductRepositoryInterface $products,
    ) {}

    public function handle(ShowProductQuery $query): ProductDetailsData
    {
        $product = $this->products->findByIdentifier($query->identifier, [
            'images',
            'main_image',
            'category',
            'brand',
            'reviews.user',
        ]);

        return new ProductDetailsData(
            product: $product,
            characteristics: $this->products->characteristics($product),
            domain: (string) config('app.url'),
        );
    }
}
