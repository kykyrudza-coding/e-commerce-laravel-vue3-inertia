<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:5',
            'phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/',
            'email' => 'required|email|max:255',
        ];
    }
}
