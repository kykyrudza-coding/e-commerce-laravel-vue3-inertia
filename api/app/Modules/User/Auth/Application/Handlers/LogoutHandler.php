<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Handlers;

use App\Modules\User\Auth\Application\Commands\LogoutCommand;

final class LogoutHandler
{
    public function handle(LogoutCommand $command): void
    {
        $token = $command->user->currentAccessToken();

        if ($token && method_exists($token, 'delete')) {
            $token->delete();
        }
    }
}
