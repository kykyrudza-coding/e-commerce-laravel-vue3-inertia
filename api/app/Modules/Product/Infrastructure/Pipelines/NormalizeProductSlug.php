<?php

declare(strict_types=1);

namespace App\Modules\Product\Infrastructure\Pipelines;

use App\Modules\Product\Infrastructure\Pipelines\Payloads\ProductPayload;
use Closure;
use Illuminate\Support\Str;

final class NormalizeProductSlug
{
    public function handle(ProductPayload $payload, Closure $next): mixed
    {
        if (array_key_exists('name', $payload->data) && empty($payload->data['slug'])) {
            $payload->data['slug'] = Str::slug($payload->data['name']);
        }

        return $next($payload);
    }
}
