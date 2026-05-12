<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\Queries;

final readonly class ShowOrderQuery
{
    public function __construct(
        public int $orderId,
        public int $userId,
    ) {}
}
