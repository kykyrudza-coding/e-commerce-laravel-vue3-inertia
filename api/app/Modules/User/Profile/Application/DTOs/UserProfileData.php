<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Application\DTOs;

use App\Models\User;

final readonly class UserProfileData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $phone,
        public ?string $address,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: (int) $user->id,
            name: $user->name,
            email: $user->email,
            phone: $user->phone,
            address: $user->address,
            createdAt: $user->created_at?->toISOString(),
            updatedAt: $user->updated_at?->toISOString(),
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
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
