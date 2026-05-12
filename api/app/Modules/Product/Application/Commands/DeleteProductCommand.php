<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Commands;

final readonly class DeleteProductCommand
{
    public function __construct(
        public string $identifier,
    ) {}
}
