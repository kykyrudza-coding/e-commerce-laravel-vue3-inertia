<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Domain\Repositories;

use App\Models\User;

interface UserProfileRepositoryInterface
{
    public function findById(int $userId, bool $withOrders = false): User;

    public function emailExistsForAnotherUser(string $email, int $userId): bool;

    public function phoneExistsForAnotherUser(string $phone, int $userId): bool;

    public function updateProfile(int $userId, array $data): User;
}
