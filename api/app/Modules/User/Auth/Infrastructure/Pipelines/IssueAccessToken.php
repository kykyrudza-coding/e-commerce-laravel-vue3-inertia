<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines;

use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\AuthPipelinePayload;
use Closure;
use RuntimeException;

final class IssueAccessToken
{
    public function handle(AuthPipelinePayload $payload, Closure $next): mixed
    {
        if (! $payload->user) {
            throw new RuntimeException('Cannot issue an access token without an authenticated user.');
        }

        $payload->token = $payload->user
            ->createToken($payload->userAgent())
            ->plainTextToken;

        return $next($payload);
    }
}
