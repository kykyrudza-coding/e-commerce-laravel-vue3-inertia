<?php

declare(strict_types=1);

namespace App\Modules\Order\Domain\ValueObjects;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case SHIPPED = 'shipped';
    case CANCELLED = 'cancelled';
}
