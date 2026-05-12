<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\User\Auth\Application\Commands\ResetPasswordCommand;

class ResetPasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'token' => ['required'],
        ];
    }

    public function toCommand(): ResetPasswordCommand
    {
        $data = $this->validated();

        return new ResetPasswordCommand(
            email: $data['email'],
            password: $data['password'],
            passwordConfirmation: $data['password_confirmation'],
            token: $data['token'],
        );
    }
}
