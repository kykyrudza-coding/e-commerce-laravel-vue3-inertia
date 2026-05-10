<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckoutStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|string|in:manual,credit_card,paypal',
            'notes' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw  new HttpResponseException(
            response()->json([
                'status' => 'error',
                'data' => $validator->errors(),
            ], 422)
        );
    }
}
