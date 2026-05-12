<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Infrastructure\Repositories;

use App\Models\User;
use App\Modules\User\Profile\Domain\Repositories\UserProfileRepositoryInterface;

final class EloquentUserProfileRepository implements UserProfileRepositoryInterface
{
    public function findById(int $userId, bool $withOrders = false): User
    {
        $query = User::query();

        if ($withOrders) {
            $query->with('orders');
        }

        return $query->findOrFail($userId);
    }

    public function emailExistsForAnotherUser(string $email, int $userId): bool
    {
        return User::query()
            ->where('email', $email)
            ->whereKeyNot($userId)
            ->exists();
    }

    public function phoneExistsForAnotherUser(string $phone, int $userId): bool
    {
        return User::query()
            ->where('phone', $phone)
            ->whereKeyNot($userId)
            ->exists();
    }

    public function updateProfile(int $userId, array $data): User
    {
        $user = $this->findById($userId);
        $user->update($data);

        return $user->refresh();
    }
}
