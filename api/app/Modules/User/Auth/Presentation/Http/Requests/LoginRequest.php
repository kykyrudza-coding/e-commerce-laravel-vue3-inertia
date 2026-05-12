<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\User\Auth\Application\Commands\LoginCommand;

class LoginRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:32',
        ];
    }

    public function toCommand(): LoginCommand
    {
        $data = $this->validated();

        return new LoginCommand(
            email: $data['email'],
            password: $data['password'],
            userAgent: $this->userAgent() ?: 'frontend',
        );
    }
}
