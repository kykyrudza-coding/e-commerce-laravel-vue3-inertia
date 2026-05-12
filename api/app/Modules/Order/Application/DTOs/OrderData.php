<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\DTOs;

use App\Models\Order;

final readonly class OrderData
{
    public function __construct(
        private Order $order,
    ) {}

    public static function fromModel(Order $order): self
    {
        return new self($order);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->order->id,
            'order_token' => $this->order->order_token,
            'status' => $this->order->status,
            'payment_method' => $this->order->payment_method,
            'transaction_id' => $this->order->transaction_id,
            'notes' => $this->order->notes,
            'total_price' => (float) $this->order->total_price,
            'currency' => $this->order->currency,
            'items' => $this->order->relationLoaded('items') ? $this->order->items : null,
            'delivery_address' => $this->order->relationLoaded('delivery_address') ? $this->order->delivery_address : null,
            'created_at' => $this->order->created_at?->toISOString(),
        ];
    }
}
