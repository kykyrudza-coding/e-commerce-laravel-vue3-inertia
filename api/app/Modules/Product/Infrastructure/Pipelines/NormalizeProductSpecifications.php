<?php

declare(strict_types=1);

namespace App\Modules\Product\Infrastructure\Pipelines;

use App\Modules\Product\Domain\ValueObjects\ProductSpecifications;
use App\Modules\Product\Infrastructure\Pipelines\Payloads\ProductPayload;
use Closure;

final class NormalizeProductSpecifications
{
    public function handle(ProductPayload $payload, Closure $next): mixed
    {
        if (array_key_exists('specifications', $payload->data)) {
            $payload->data['specifications'] = new ProductSpecifications($payload->data['specifications'] ?? [])
                ->normalized();
        }

        return $next($payload);
    }
}
