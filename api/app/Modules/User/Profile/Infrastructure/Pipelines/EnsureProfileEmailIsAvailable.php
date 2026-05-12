<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Infrastructure\Pipelines;

use App\Modules\User\Profile\Domain\Exceptions\ProfileEmailAlreadyTakenException;
use App\Modules\User\Profile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\User\Profile\Infrastructure\Pipelines\Payloads\UpdateProfilePayload;
use Closure;

final readonly class EnsureProfileEmailIsAvailable
{
    public function __construct(
        private UserProfileRepositoryInterface $profiles,
    ) {}

    public function handle(UpdateProfilePayload $payload, Closure $next): mixed
    {
        if ($this->profiles->emailExistsForAnotherUser(
            email: $payload->command->email->value,
            userId: $payload->command->userId,
        )) {
            throw new ProfileEmailAlreadyTakenException();
        }

        return $next($payload);
    }
}
