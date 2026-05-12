<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Presentation\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Modules\User\Profile\Application\Commands\UpdateProfileCommand;
use App\Modules\User\Profile\Domain\ValueObjects\ProfileEmail;
use App\Modules\User\Profile\Domain\ValueObjects\ProfileName;
use App\Modules\User\Profile\Domain\ValueObjects\ProfilePhone;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'name' => 'required|string|max:255|min:5',
            'phone' => [
                'required',
                'regex:/^\d{3}-\d{3}-\d{4}$/',
                Rule::unique('users', 'phone')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];
    }

    public function toCommand(): UpdateProfileCommand
    {
        $data = $this->validated();

        return new UpdateProfileCommand(
            userId: (int) $this->user()->id,
            name: new ProfileName($data['name']),
            phone: new ProfilePhone($data['phone']),
            email: new ProfileEmail($data['email']),
        );
    }
}
