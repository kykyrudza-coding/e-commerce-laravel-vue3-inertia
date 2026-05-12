<?php

declare(strict_types=1);

namespace App\Modules\Product\Infrastructure\Pipelines;

use App\Modules\Product\Application\Commands\CreateProductCommand;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Product\Infrastructure\Pipelines\Payloads\ProductPayload;
use Closure;

final readonly class PersistProduct
{
    public function __construct(
        private ProductRepositoryInterface $products,
    ) {}

    public function handle(ProductPayload $payload, Closure $next): mixed
    {
        $payload->product = $payload->command instanceof CreateProductCommand
            ? $this->products->create($payload->data)
            : $this->products->update((string) $payload->identifier(), $payload->data);

        return $next($payload);
    }
}
