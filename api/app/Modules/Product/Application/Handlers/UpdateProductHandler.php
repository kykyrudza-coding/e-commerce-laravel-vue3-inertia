<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Handlers;

use App\Modules\Product\Application\Commands\UpdateProductCommand;
use App\Modules\Product\Application\DTOs\ProductData;
use App\Modules\Product\Infrastructure\Pipelines\MergeExistingProductSpecifications;
use App\Modules\Product\Infrastructure\Pipelines\NormalizeProductSlug;
use App\Modules\Product\Infrastructure\Pipelines\NormalizeProductSpecifications;
use App\Modules\Product\Infrastructure\Pipelines\Payloads\ProductPayload;
use App\Modules\Product\Infrastructure\Pipelines\PersistProduct;
use Illuminate\Pipeline\Pipeline;
use RuntimeException;

final readonly class UpdateProductHandler
{
    public function __construct(
        private Pipeline $pipeline,
    ) {}

    public function handle(UpdateProductCommand $command): ProductData
    {
        /** @var ProductPayload $payload */
        $payload = $this->pipeline
            ->send(new ProductPayload($command))
            ->through([
                NormalizeProductSlug::class,
                MergeExistingProductSpecifications::class,
                NormalizeProductSpecifications::class,
                PersistProduct::class,
            ])
            ->thenReturn();

        if (! $payload->product) {
            throw new RuntimeException('Update product pipeline finished without a product.');
        }

        return ProductData::fromModel($payload->product);
    }
}
