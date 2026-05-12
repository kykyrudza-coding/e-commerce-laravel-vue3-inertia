<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Commands;

final readonly class UpdateProductCommand
{
    public function __construct(
        public string $identifier,
        public array $data,
    ) {}
}
