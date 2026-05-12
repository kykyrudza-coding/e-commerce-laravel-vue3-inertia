<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\QueryHandlers;

use App\Modules\Order\Application\DTOs\OrderListData;
use App\Modules\Order\Application\Queries\ListOrdersQuery;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;

final readonly class ListOrdersHandler
{
    public function __construct(
        private OrderRepositoryInterface $orders,
    ) {}

    public function handle(ListOrdersQuery $query): OrderListData
    {
        return new OrderListData(
            $this->orders->paginateForUser($query->userId, $query->perPage),
        );
    }
}
