<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Commands;

final readonly class AddProductReviewCommand
{
    public function __construct(
        public string $productIdentifier,
        public int $userId,
        public int $rating,
        public string $review,
    ) {}
}
