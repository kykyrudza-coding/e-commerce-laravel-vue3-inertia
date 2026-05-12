<?php

declare(strict_types=1);

namespace App\Modules\Order\Application\Commands;

use App\Modules\Order\Domain\ValueObjects\PaymentMethod;

final readonly class CreateOrderCommand
{
    public function __construct(
        public int $userId,
        public array $items,
        public PaymentMethod $paymentMethod,
        public ?string $notes,
    ) {}
}
