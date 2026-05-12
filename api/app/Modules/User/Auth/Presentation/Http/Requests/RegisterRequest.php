<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\User\Auth\Application\Commands\RegisterCommand;

class RegisterRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:5|unique:users,name',
            'phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/|unique:users,phone',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:32|confirmed',
        ];
    }

    public function toCommand(): RegisterCommand
    {
        $data = $this->validated();

        return new RegisterCommand(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            phone: $data['phone'] ?? null,
            userAgent: $this->userAgent() ?: 'frontend',
        );
    }
}
