<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines;

use App\Enums\HttpCodeEnum;
use App\Models\User;
use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\AuthPipelinePayload;
use App\Support\ApiResponse;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;

final class FindUserByEmail
{
    public function handle(AuthPipelinePayload $payload, Closure $next): mixed
    {
        $payload->user = User::query()
            ->where('email', $payload->command->email)
            ->first();

        if (! $payload->user) {
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
