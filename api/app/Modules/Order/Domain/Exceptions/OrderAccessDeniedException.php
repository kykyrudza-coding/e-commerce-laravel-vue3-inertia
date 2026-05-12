<?php

declare(strict_types=1);

namespace App\Modules\Order\Domain\Exceptions;

use RuntimeException;

final class OrderAccessDeniedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('You do not have access to this order.');
    }
}
