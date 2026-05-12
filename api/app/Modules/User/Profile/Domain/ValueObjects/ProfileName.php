<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Domain\ValueObjects;

final readonly class ProfileName
{
    public function __construct(
        public string $value,
    ) {}
}
