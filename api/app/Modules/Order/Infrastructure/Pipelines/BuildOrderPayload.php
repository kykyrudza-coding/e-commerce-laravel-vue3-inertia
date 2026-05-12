<?php

declare(strict_types=1);

namespace App\Modules\Order\Infrastructure\Pipelines;

use App\Modules\Order\Domain\ValueObjects\OrderStatus;
use App\Modules\Order\Infrastructure\Pipelines\Payloads\CreateOrderPayload;
use Closure;
use Illuminate\Support\Str;

final class BuildOrderPayload
{
    public function handle(CreateOrderPayload $payload, Closure $next): mixed
    {
        $payload->orderData = [
            'user_id' => $payload->command->userId,
            'order_token' => (string) Str::uuid(),
            'status' => OrderStatus::PENDING->value,
            'payment_method' => $payload->command->paymentMethod->value,
            'notes' => $payload->command->notes,
            'total_price' => $payload->total,
        ];

        $payload->itemsData = collect($payload->command->items)
            ->map(fn (array $item): array => [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $payload->products[$item['product_id']]->price,
            ])
            ->all();

        return $next($payload);
    }
}
