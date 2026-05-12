<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\DTOs;

use App\Models\Review;

final readonly class ReviewData
{
    public function __construct(
        private Review $review,
    ) {}

    public static function fromModel(Review $review): self
    {
        return new self($review);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->review->id,
            'rating' => $this->review->rating,
            'comment' => $this->review->review,
            'review' => $this->review->review,
            'user' => $this->review->relationLoaded('user') ? $this->review->user : null,
            'created_at' => $this->review->created_at,
        ];
    }
}
