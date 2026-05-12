<?php

declare(strict_types=1);

namespace App\Modules\Order\Infrastructure\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Modules\Order\Domain\Exceptions\OrderAccessDeniedException;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function paginateForUser(int $userId, int $perPage): LengthAwarePaginator
    {
        return Order::query()
            ->with(['items.product', 'delivery_address'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function findForUser(int $orderId, int $userId): Order
    {
        $order = Order::query()
            ->with(['items.product', 'delivery_address'])
            ->whereKey($orderId)
            ->firstOrFail();

        if ((int) $order->user_id !== $userId) {
            throw new OrderAccessDeniedException();
        }

        return $order;
    }

    public function productsByIds(array $productIds): Collection
    {
        return Product::query()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');
    }

    public function createWithItems(array $orderData, array $items): Order
    {
        return DB::transaction(function () use ($orderData, $items): Order {
            $order = Order::query()->create($orderData);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            return $order->load(['items.product', 'delivery_address']);
        });
    }
}
