<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Commands;

final readonly class RegisterCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $phone,
        public string $userAgent,
    ) {}
}
