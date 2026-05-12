<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines\Payloads;

use App\Models\User;
use App\Modules\User\Auth\Application\Commands\ForgotPasswordCommand;

final class PasswordResetPipelinePayload
{
    public ?User $user = null;

    public function __construct(
        public readonly ForgotPasswordCommand $command,
    ) {}
}
