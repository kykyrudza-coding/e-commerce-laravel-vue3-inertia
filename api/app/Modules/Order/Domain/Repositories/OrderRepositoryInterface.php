<?php

declare(strict_types=1);

namespace App\Modules\Order\Domain\Repositories;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function paginateForUser(int $userId, int $perPage): LengthAwarePaginator;

    public function findForUser(int $orderId, int $userId): Order;

    public function productsByIds(array $productIds): Collection;

    public function createWithItems(array $orderData, array $items): Order;
}
