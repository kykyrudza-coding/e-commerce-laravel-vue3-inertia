<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Commands;

final readonly class LoginCommand
{
    public function __construct(
        public string $email,
        public string $password,
        public string $userAgent,
    ) {}
}
