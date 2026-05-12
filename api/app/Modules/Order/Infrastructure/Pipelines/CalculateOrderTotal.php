<?php

declare(strict_types=1);

namespace App\Modules\Order\Infrastructure\Pipelines;

use App\Modules\Order\Infrastructure\Pipelines\Payloads\CreateOrderPayload;
use Closure;

final class CalculateOrderTotal
{
    public function handle(CreateOrderPayload $payload, Closure $next): mixed
    {
        $payload->total = collect($payload->command->items)
            ->sum(fn (array $item): float => (float) $payload->products[$item['product_id']]->price * (int) $item['quantity']);

        return $next($payload);
    }
}
