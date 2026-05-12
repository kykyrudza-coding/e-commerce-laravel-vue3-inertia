<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\DTOs;

use App\Models\User;

final readonly class AuthSessionData
{
    public function __construct(
        public UserData $user,
        public string $token,
    ) {}

    public static function fromUserAndToken(User $user, string $token): self
    {
        return new self(
            user: UserData::fromModel($user),
            token: $token,
        );
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user->toArray(),
            'token' => $this->token,
        ];
    }
}
