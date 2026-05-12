<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Queries;

final readonly class ShowProductQuery
{
    public function __construct(
        public string $identifier,
    ) {}
}
