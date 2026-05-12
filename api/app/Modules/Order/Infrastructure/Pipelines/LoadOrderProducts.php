<?php

declare(strict_types=1);

namespace App\Modules\Order\Infrastructure\Pipelines;

use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Modules\Order\Infrastructure\Pipelines\Payloads\CreateOrderPayload;
use Closure;

final readonly class LoadOrderProducts
{
    public function __construct(
        private OrderRepositoryInterface $orders,
    ) {}

    public function handle(CreateOrderPayload $payload, Closure $next): mixed
    {
        $payload->products = $this->orders->productsByIds(
            collect($payload->command->items)->pluck('product_id')->all(),
        );

        return $next($payload);
    }
}
