<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Application\Handlers;

use App\Modules\User\Profile\Application\Commands\UpdateProfileCommand;
use App\Modules\User\Profile\Application\DTOs\UserProfileData;
use App\Modules\User\Profile\Infrastructure\Pipelines\EnsureProfileEmailIsAvailable;
use App\Modules\User\Profile\Infrastructure\Pipelines\EnsureProfilePhoneIsAvailable;
use App\Modules\User\Profile\Infrastructure\Pipelines\Payloads\UpdateProfilePayload;
use App\Modules\User\Profile\Infrastructure\Pipelines\PersistProfileChanges;
use Illuminate\Pipeline\Pipeline;
use RuntimeException;

final readonly class UpdateProfileHandler
{
    public function __construct(
        private Pipeline $pipeline,
    ) {}

    public function handle(UpdateProfileCommand $command): UserProfileData
    {
        /** @var UpdateProfilePayload $payload */
        $payload = $this->pipeline
            ->send(new UpdateProfilePayload($command))
            ->through([
                EnsureProfileEmailIsAvailable::class,
                EnsureProfilePhoneIsAvailable::class,
                PersistProfileChanges::class,
            ])
            ->thenReturn();

        if (! $payload->user) {
            throw new RuntimeException('Profile update pipeline finished without a user.');
        }

        return UserProfileData::fromModel($payload->user);
    }
}
