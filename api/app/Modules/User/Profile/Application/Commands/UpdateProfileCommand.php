<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Application\Commands;

use App\Modules\User\Profile\Domain\ValueObjects\ProfileEmail;
use App\Modules\User\Profile\Domain\ValueObjects\ProfileName;
use App\Modules\User\Profile\Domain\ValueObjects\ProfilePhone;

final readonly class UpdateProfileCommand
{
    public function __construct(
        public int $userId,
        public ProfileName $name,
        public ProfilePhone $phone,
        public ProfileEmail $email,
    ) {}
}
