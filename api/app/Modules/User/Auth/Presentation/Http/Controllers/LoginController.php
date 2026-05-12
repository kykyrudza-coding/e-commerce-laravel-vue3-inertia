<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Auth\Application\Handlers\LoginHandler;
use App\Modules\User\Auth\Application\Handlers\LogoutHandler;
use App\Modules\User\Auth\Presentation\Http\Requests\LoginRequest;
use App\Modules\User\Auth\Presentation\Http\Requests\LogoutRequest;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function store(LoginRequest $request, LoginHandler $handler): JsonResponse
    {
        $session = $handler->handle($request->toCommand());

        return ApiResponse::success(
            data: $session->toArray(),
            message: 'Authenticated.',
        );
    }

    public function logout(LogoutRequest $request, LogoutHandler $handler): JsonResponse
    {
        $handler->handle($request->toCommand());

        return ApiResponse::success(
            message: 'Logged out.',
        );
    }
}
