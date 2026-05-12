<?php

declare(strict_types=1);

namespace App\Modules\Order\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\Order\Application\Commands\CreateOrderCommand;
use App\Modules\Order\Domain\ValueObjects\PaymentMethod;

class StoreOrderRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function toCommand(): CreateOrderCommand
    {
        $data = $this->validated();

        return new CreateOrderCommand(
            userId: (int) $this->user()->id,
            items: $data['items'],
            paymentMethod: new PaymentMethod($data['payment_method'] ?? 'manual'),
            notes: $data['notes'] ?? null,
        );
    }
}
