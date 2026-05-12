<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Application\Commands;

use App\Models\User;

final readonly class LogoutCommand
{
    public function __construct(
        public User $user,
    ) {}
}
