<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\DTOs;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class OrderListData
{
    public function __construct(
        private LengthAwarePaginator $orders,
    ) {}

    public function data(): array
    {
        return collect($this->orders->items())
            ->map(fn ($order): array => OrderData::fromModel($order)->toArray())
            ->all();
    }

    public function meta(): array
    {
        return [
            'total' => $this->orders->total(),
            'per_page' => $this->orders->perPage(),
            'current_page' => $this->orders->currentPage(),
            'last_page' => $this->orders->lastPage(),
            'from' => $this->orders->firstItem(),
            'to' => $this->orders->lastItem(),
        ];
    }
}
