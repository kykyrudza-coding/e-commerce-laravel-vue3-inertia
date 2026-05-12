<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Infrastructure\Pipelines\Payloads;

use App\Models\User;
use App\Modules\User\Profile\Application\Commands\UpdateProfileCommand;

final class UpdateProfilePayload
{
    public ?User $user = null;

    public function __construct(
        public readonly UpdateProfileCommand $command,
    ) {}

    public function updateData(): array
    {
        return [
            'name' => $this->command->name->value,
            'phone' => $this->command->phone->value,
            'email' => $this->command->email->value,
        ];
    }
}
