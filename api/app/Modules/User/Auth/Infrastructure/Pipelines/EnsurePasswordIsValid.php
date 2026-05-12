<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines;

use App\Enums\HttpCodeEnum;
use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\AuthPipelinePayload;
use App\Support\ApiResponse;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

final class EnsurePasswordIsValid
{
    public function handle(AuthPipelinePayload $payload, Closure $next): mixed
    {
        if (! $payload->user || ! Hash::check($payload->command->password, $payload->user->password)) {
            throw new HttpResponseException(
                ApiResponse::error(
                    message: 'The provided credentials are incorrect.',
                    errors: ['email' => ['The provided credentials are incorrect.']],
                    code: HttpCodeEnum::UNPROCESSABLE_ENTITY,
                ),
            );
        }

        return $next($payload);
    }
}
