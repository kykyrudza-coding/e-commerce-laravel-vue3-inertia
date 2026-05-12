<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Queries;

final readonly class ListProductsQuery
{
    public function __construct(
        public array $filters,
        public int $perPage = 15,
    ) {}
}
