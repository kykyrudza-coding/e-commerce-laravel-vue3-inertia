<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines;

use App\Models\User;
use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\PasswordResetPipelinePayload;
use Closure;

final class FindPasswordResetUser
{
    public function handle(PasswordResetPipelinePayload $payload, Closure $next): mixed
    {
        $payload->user = User::query()
            ->where('email', $payload->command->email)
            ->first();

        return $next($payload);
    }
}
