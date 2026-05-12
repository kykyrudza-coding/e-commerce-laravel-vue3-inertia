<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Infrastructure\Pipelines;

use App\Modules\User\Profile\Domain\Exceptions\ProfilePhoneAlreadyTakenException;
use App\Modules\User\Profile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\User\Profile\Infrastructure\Pipelines\Payloads\UpdateProfilePayload;
use Closure;

final readonly class EnsureProfilePhoneIsAvailable
{
    public function __construct(
        private UserProfileRepositoryInterface $profiles,
    ) {}

    public function handle(UpdateProfilePayload $payload, Closure $next): mixed
    {
        if ($this->profiles->phoneExistsForAnotherUser(
            phone: $payload->command->phone->value,
            userId: $payload->command->userId,
        )) {
            throw new ProfilePhoneAlreadyTakenException();
        }

        return $next($payload);
    }
}
