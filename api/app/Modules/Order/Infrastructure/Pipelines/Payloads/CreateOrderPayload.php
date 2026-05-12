<?php

declare(strict_types=1);

namespace App\Modules\Order\Infrastructure\Pipelines\Payloads;

use App\Models\Order;
use App\Modules\Order\Application\Commands\CreateOrderCommand;
use Illuminate\Support\Collection;

final class CreateOrderPayload
{
    public Collection $products;

    public float $total = 0.0;

    public array $orderData = [];

    public array $itemsData = [];

    public ?Order $order = null;

    public function __construct(
        public readonly CreateOrderCommand $command,
    ) {
        $this->products = collect();
    }
}
