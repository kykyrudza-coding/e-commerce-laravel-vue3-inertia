<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;
use App\Modules\User\Auth\Application\Commands\LogoutCommand;

class LogoutRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function toCommand(): LogoutCommand
    {
        /** @var User $user */
        $user = $this->user();

        return new LogoutCommand($user);
    }
}
