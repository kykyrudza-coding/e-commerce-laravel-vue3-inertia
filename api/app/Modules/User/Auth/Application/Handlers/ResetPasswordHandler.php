<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Handlers;

use App\Enums\HttpCodeEnum;
use App\Modules\User\Auth\Application\Commands\ResetPasswordCommand;
use App\Support\ApiResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

final class ResetPasswordHandler
{
    public function handle(ResetPasswordCommand $command): string
    {
        $response = Password::reset(
            $command->toPasswordBrokerPayload(),
            function ($user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            },
        );

        if ($response !== Password::PASSWORD_RESET) {
            throw new HttpResponseException(
                ApiResponse::error(
                    message: trans($response),
                    errors: ['email' => [trans($response)]],
                    code: HttpCodeEnum::UNPROCESSABLE_ENTITY,
                ),
            );
        }

        return trans($response);
    }
}
