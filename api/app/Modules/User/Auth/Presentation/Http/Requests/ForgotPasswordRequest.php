<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\User\Auth\Application\Commands\ForgotPasswordCommand;

class ForgotPasswordRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function toCommand(): ForgotPasswordCommand
    {
        $data = $this->validated();

        return new ForgotPasswordCommand(
            email: $data['email'],
        );
    }
}
