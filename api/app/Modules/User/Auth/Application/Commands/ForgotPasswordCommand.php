<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Commands;

final readonly class ForgotPasswordCommand
{
    public function __construct(
        public string $email,
    ) {}
}
