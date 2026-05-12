<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Application\Queries;

final readonly class GetCurrentUserQuery
{
    public function __construct(
        public int $userId,
        public bool $withOrders = false,
    ) {}
}
