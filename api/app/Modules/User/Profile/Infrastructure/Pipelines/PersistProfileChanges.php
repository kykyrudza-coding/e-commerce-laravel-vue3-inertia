<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Infrastructure\Pipelines;

use App\Modules\User\Profile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\User\Profile\Infrastructure\Pipelines\Payloads\UpdateProfilePayload;
use Closure;

final readonly class PersistProfileChanges
{
    public function __construct(
        private UserProfileRepositoryInterface $profiles,
    ) {}

    public function handle(UpdateProfilePayload $payload, Closure $next): mixed
    {
        $payload->user = $this->profiles->updateProfile(
            userId: $payload->command->userId,
            data: $payload->updateData(),
        );

        return $next($payload);
    }
}
