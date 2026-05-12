<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\Handlers;

use App\Modules\Order\Application\Commands\CreateOrderCommand;
use App\Modules\Order\Application\DTOs\OrderData;
use App\Modules\Order\Infrastructure\Pipelines\BuildOrderPayload;
use App\Modules\Order\Infrastructure\Pipelines\CalculateOrderTotal;
use App\Modules\Order\Infrastructure\Pipelines\LoadOrderProducts;
use App\Modules\Order\Infrastructure\Pipelines\Payloads\CreateOrderPayload;
use App\Modules\Order\Infrastructure\Pipelines\PersistOrder;
use Illuminate\Pipeline\Pipeline;
use RuntimeException;

final readonly class CreateOrderHandler
{
    public function __construct(
        private Pipeline $pipeline,
    ) {}

    public function handle(CreateOrderCommand $command): OrderData
    {
        /** @var CreateOrderPayload $payload */
        $payload = $this->pipeline
            ->send(new CreateOrderPayload($command))
            ->through([
                LoadOrderProducts::class,
                CalculateOrderTotal::class,
                BuildOrderPayload::class,
                PersistOrder::class,
            ])
            ->thenReturn();

        if (! $payload->order) {
            throw new RuntimeException('Create order pipeline finished without an order.');
        }

        return OrderData::fromModel($payload->order);
    }
}
