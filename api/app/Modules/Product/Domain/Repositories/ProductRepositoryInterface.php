<?php

declare(strict_types=1);

namespace App\Modules\Product\Domain\Repositories;

use App\Models\Product;
use App\Models\Review;
use App\Modules\Product\Application\Queries\ListProductsQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function paginate(ListProductsQuery $query): LengthAwarePaginator;

    public function findByIdentifier(string $identifier, array $with = []): Product;

    public function create(array $data): Product;

    public function update(string $identifier, array $data): Product;

    public function delete(string $identifier): void;

    public function search(?string $term): Collection;

    public function filters(): array;

    public function characteristics(Product $product): array;

    public function createReview(int $productId, int $userId, int $rating, string $review): Review;
}
