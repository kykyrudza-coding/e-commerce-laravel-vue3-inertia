<?php

declare(strict_types=1);

namespace App\Modules\Product\Infrastructure\Pipelines;

use App\Modules\Product\Application\Commands\UpdateProductCommand;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Product\Infrastructure\Pipelines\Payloads\ProductPayload;
use Closure;

final readonly class MergeExistingProductSpecifications
{
    public function __construct(
        private ProductRepositoryInterface $products,
    ) {}

    public function handle(ProductPayload $payload, Closure $next): mixed
    {
        if ($payload->command instanceof UpdateProductCommand && array_key_exists('specifications', $payload->data)) {
            $product = $this->products->findByIdentifier($payload->command->identifier);
            $payload->data['specifications'] = array_merge(
                $product->specifications ?? [],
                $payload->data['specifications'] ?? [],
            );
        }

        return $next($payload);
    }
}
