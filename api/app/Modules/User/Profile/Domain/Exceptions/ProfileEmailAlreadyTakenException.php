<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Domain\Exceptions;

use RuntimeException;

final class ProfileEmailAlreadyTakenException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The email has already been taken.');
    }
}
