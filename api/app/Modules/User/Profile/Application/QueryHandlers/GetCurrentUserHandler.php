<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Application\QueryHandlers;

use App\Modules\User\Profile\Application\DTOs\UserProfileData;
use App\Modules\User\Profile\Application\Queries\GetCurrentUserQuery;
use App\Modules\User\Profile\Domain\Repositories\UserProfileRepositoryInterface;

final readonly class GetCurrentUserHandler
{
    public function __construct(
        private UserProfileRepositoryInterface $profiles,
    ) {}

    public function handle(GetCurrentUserQuery $query): UserProfileData
    {
        $user = $this->profiles->findById(
            userId: $query->userId,
            withOrders: $query->withOrders,
        );

        return UserProfileData::fromModel($user);
    }
}
