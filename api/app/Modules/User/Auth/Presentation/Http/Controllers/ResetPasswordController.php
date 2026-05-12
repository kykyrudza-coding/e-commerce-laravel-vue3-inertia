<?php

declare(strict_types=1);

namespace App\Modules\User\Auth\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Auth\Application\Handlers\ResetPasswordHandler;
use App\Modules\User\Auth\Presentation\Http\Requests\ResetPasswordRequest;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request, ResetPasswordHandler $handler): JsonResponse
    {
        $message = $handler->handle($request->toCommand());

        return ApiResponse::success(
            message: $message,
        );
    }
}
