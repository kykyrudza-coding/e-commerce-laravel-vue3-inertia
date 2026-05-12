<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Infrastructure\Pipelines;

use App\Models\User;
use App\Modules\User\Auth\Application\Commands\RegisterCommand;
use App\Modules\User\Auth\Infrastructure\Pipelines\Payloads\AuthPipelinePayload;
use Closure;
use Illuminate\Support\Facades\Hash;

final class CreateRegisteredUser
{
    public function handle(AuthPipelinePayload $payload, Closure $next): mixed
    {
        /** @var RegisterCommand $command */
        $command = $payload->command;

        $payload->user = User::query()->create([
            'name' => $command->name,
            'email' => $command->email,
            'password' => Hash::make($command->password),
            'phone' => $command->phone,
        ]);

        return $next($payload);
    }
}
