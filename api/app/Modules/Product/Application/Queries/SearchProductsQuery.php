<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Queries;

final readonly class SearchProductsQuery
{
    public function __construct(
        public ?string $term,
    ) {}
}
