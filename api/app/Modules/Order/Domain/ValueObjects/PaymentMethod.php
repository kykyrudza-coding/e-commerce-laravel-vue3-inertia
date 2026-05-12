<?php

declare(strict_types=1);

namespace App\Modules\Order\Domain\ValueObjects;

final readonly class PaymentMethod
{
    public function __construct(
        public string $value = 'manual',
    ) {}
}
