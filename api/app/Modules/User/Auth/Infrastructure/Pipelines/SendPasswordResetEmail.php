<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines;

use App\Mail\ResetPasswordEmail;
use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\PasswordResetPipelinePayload;
use Closure;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

final class SendPasswordResetEmail
{
    public function handle(PasswordResetPipelinePayload $payload, Closure $next): mixed
    {
        if ($payload->user) {
            $token = Password::createToken($payload->user);

            Mail::to($payload->user->email)
                ->send(new ResetPasswordEmail(
                    user: $payload->user,
                    token: $token,
                ));
        }

        return $next($payload);
    }
}
