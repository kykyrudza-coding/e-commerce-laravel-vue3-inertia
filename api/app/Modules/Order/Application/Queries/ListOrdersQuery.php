<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\Queries;

final readonly class ListOrdersQuery
{
    public function __construct(
        public int $userId,
        public int $perPage = 15,
    ) {}
}
