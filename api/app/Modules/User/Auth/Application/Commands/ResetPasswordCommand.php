<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Commands;

final readonly class ResetPasswordCommand
{
    public function __construct(
        public string $email,
        public string $password,
        public string $passwordConfirmation,
        public string $token,
    ) {}

    public function toPasswordBrokerPayload(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
            'token' => $this->token,
        ];
    }
}
