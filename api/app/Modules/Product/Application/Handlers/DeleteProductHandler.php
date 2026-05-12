<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Handlers;

use App\Modules\Product\Application\Commands\DeleteProductCommand;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;

final readonly class DeleteProductHandler
{
    public function __construct(
        private ProductRepositoryInterface $products,
    ) {}

    public function handle(DeleteProductCommand $command): void
    {
        $this->products->delete($command->identifier);
    }
}
