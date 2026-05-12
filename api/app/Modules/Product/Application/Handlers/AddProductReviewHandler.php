<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\Handlers;

use App\Modules\Product\Application\Commands\AddProductReviewCommand;
use App\Modules\Product\Application\DTOs\ReviewData;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;

final readonly class AddProductReviewHandler
{
    public function __construct(
        private ProductRepositoryInterface $products,
    ) {}

    public function handle(AddProductReviewCommand $command): ReviewData
    {
        $product = $this->products->findByIdentifier($command->productIdentifier);

        return ReviewData::fromModel(
            $this->products->createReview(
                productId: (int) $product->id,
                userId: $command->userId,
                rating: $command->rating,
                review: $command->review,
            ),
        );
    }
}
