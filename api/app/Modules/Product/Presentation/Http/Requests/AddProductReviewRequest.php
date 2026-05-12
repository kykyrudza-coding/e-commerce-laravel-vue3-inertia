<?php

declare(strict_types=1);

namespace App\Modules\Product\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\Product\Application\Commands\AddProductReviewCommand;

class AddProductReviewRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required_without:review', 'string', 'max:5000'],
            'review' => ['required_without:comment', 'string', 'max:5000'],
        ];
    }

    public function toCommand(): AddProductReviewCommand
    {
        $data = $this->validated();

        return new AddProductReviewCommand(
            productIdentifier: (string) $this->route('product'),
            userId: (int) $this->user()->id,
            rating: (int) $data['rating'],
            review: $data['review'] ?? $data['comment'],
        );
    }
}
