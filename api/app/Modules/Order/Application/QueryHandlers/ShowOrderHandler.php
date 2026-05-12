<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\QueryHandlers;

use App\Modules\Order\Application\DTOs\OrderData;
use App\Modules\Order\Application\Queries\ShowOrderQuery;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;

final readonly class ShowOrderHandler
{
    public function __construct(
        private OrderRepositoryInterface $orders,
    ) {}

    public function handle(ShowOrderQuery $query): OrderData
    {
        return OrderData::fromModel(
            $this->orders->findForUser($query->orderId, $query->userId),
        );
    }
}
