<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Controllers;

use App\Enums\HttpCodeEnum;
use App\Http\Controllers\Controller;
use App\Modules\User\Auth\Application\Handlers\RegisterHandler;
use App\Modules\User\Auth\Presentation\Http\Requests\RegisterRequest;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request, RegisterHandler $handler): JsonResponse
    {
        $session = $handler->handle($request->toCommand());

        return ApiResponse::success(
            data: $session->toArray(),
            message: 'Registered.',
            code: HttpCodeEnum::CREATED,
        );
    }
}
