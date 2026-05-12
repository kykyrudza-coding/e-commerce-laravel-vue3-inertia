<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Auth\Application\Handlers\ForgotPasswordHandler;
use App\Modules\User\Auth\Presentation\Http\Requests\ForgotPasswordRequest;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    public function store(ForgotPasswordRequest $request, ForgotPasswordHandler $handler): JsonResponse
    {
        $handler->handle($request->toCommand());

        return ApiResponse::success(
            message: 'If the account exists, a reset email has been sent.',
        );
    }
}
