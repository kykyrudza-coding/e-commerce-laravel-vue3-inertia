<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use App\Http\Requests\BaseFormRequest;
use App\Modules\Order\Application\Commands\CheckoutCommand;

class CheckoutStoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'payment_method' => 'nullable|string|in:manual,credit_card,paypal',
            'notes' => 'nullable|string',
        ];
    }

    public function toCommand(): CheckoutCommand
    {
        $data = $this->validated();

        return new CheckoutCommand(
            paymentMethod: $data['payment_method'] ?? 'manual',
            notes: $data['notes'] ?? null,
        );
    }
}
