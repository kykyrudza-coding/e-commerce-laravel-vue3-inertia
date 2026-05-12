<?php

declare(strict_types=1);

namespace App\Modules\User\Profile\Presentation\Http\Controllers;

use App\Enums\HttpCodeEnum;
use App\Http\Controllers\Controller;
use App\Modules\User\Profile\Application\Handlers\UpdateProfileHandler;
use App\Modules\User\Profile\Application\Queries\GetCurrentUserQuery;
use App\Modules\User\Profile\Application\QueryHandlers\GetCurrentUserHandler;
use App\Modules\User\Profile\Domain\Exceptions\ProfileEmailAlreadyTakenException;
use App\Modules\User\Profile\Domain\Exceptions\ProfilePhoneAlreadyTakenException;
use App\Modules\User\Profile\Presentation\Http\Requests\UpdateProfileRequest;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function user(Request $request, GetCurrentUserHandler $handler): JsonResponse
    {
        $user = $request->user();

        $profile = $handler->handle(new GetCurrentUserQuery((int) $user->id));

        return ApiResponse::success(
            data: $profile->toArray(),
        );
    }

    public function index(Request $request, GetCurrentUserHandler $handler): JsonResponse
    {
        $user = $request->user();

        $profile = $handler->handle(new GetCurrentUserQuery((int) $user->id, withOrders: true));

        return ApiResponse::success(
            data: $profile->toArray(),
        );
    }

    public function update(UpdateProfileRequest $request, UpdateProfileHandler $handler): JsonResponse
    {
        try {
            $profile = $handler->handle($request->toCommand());
        } catch (ProfileEmailAlreadyTakenException $exception) {
            return ApiResponse::error(
                message: $exception->getMessage(),
                errors: ['email' => [$exception->getMessage()]],
                code: HttpCodeEnum::UNPROCESSABLE_ENTITY,
            );
        } catch (ProfilePhoneAlreadyTakenException $exception) {
            return ApiResponse::error(
                message: $exception->getMessage(),
                errors: ['phone' => [$exception->getMessage()]],
                code: HttpCodeEnum::UNPROCESSABLE_ENTITY,
            );
        }

        return ApiResponse::success(
            data: $profile->toArray(),
            message: 'Profile updated.',
        );
    }
}
