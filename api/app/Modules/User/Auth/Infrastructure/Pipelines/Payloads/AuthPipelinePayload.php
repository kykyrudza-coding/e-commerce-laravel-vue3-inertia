<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines\Payloads;

use App\Models\User;
use App\Modules\User\Auth\Application\Commands\LoginCommand;
use App\Modules\User\Auth\Application\Commands\RegisterCommand;

final class AuthPipelinePayload
{
    public ?User $user = null;

    public ?string $token = null;

    public function __construct(
        public readonly LoginCommand|RegisterCommand $command,
    ) {}

    public function userAgent(): string
    {
        return $this->command->userAgent;
    }
}
