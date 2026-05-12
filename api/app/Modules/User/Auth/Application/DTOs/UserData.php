<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\DTOs;

use App\Models\User;

final readonly class UserData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $phone,
        public ?string $address,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: (int) $user->id,
            name: $user->name,
            email: $user->email,
            phone: $user->phone,
            address: $user->address,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ];
    }
}
