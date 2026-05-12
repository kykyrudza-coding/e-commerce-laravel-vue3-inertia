<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\Commands;

final readonly class CheckoutCommand
{
    public function __construct(
        public string $paymentMethod,
        public ?string $notes,
    ) {}
}
