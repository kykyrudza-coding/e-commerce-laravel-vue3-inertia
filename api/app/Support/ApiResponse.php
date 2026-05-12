<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\HttpCodeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

final class ApiResponse
{
    public static function success(
        mixed $data = null,
        string $message = 'OK',
        array $meta = [],
        HttpCodeEnum $code = HttpCodeEnum::OK,
    ): JsonResponse {
        return response()->json(
            self::payload(
                success: true,
                message: $message,
                data: $data,
                errors: [],
                meta: $meta,
            ),
            $code->value,
        );
    }

    public static function error(
        string $message,
        array|MessageBag|ViewErrorBag $errors = [],
        mixed $data = null,
        array $meta = [],
        HttpCodeEnum $code = HttpCodeEnum::BAD_REQUEST,
    ): JsonResponse {
        return response()->json(
            self::payload(
                success: false,
                message: $message,
                data: $data,
                errors: self::normalizeErrors($errors),
                meta: $meta,
            ),
            $code->value,
        );
    }

    public static function validationError(array|MessageBag|ViewErrorBag $errors): JsonResponse
    {
        return self::error(
            message: 'Validation failed.',
            errors: $errors,
            code: HttpCodeEnum::UNPROCESSABLE_ENTITY,
        );
    }

    private static function payload(
        bool $success,
        string $message,
        mixed $data,
        array $errors,
        array $meta,
    ): array {
        return [
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
            'meta' => $meta,
        ];
    }

    private static function normalizeErrors(array|MessageBag|ViewErrorBag $errors): array
    {
        if ($errors instanceof ViewErrorBag) {
            return $errors->toArray();
        }

        if ($errors instanceof MessageBag) {
            return $errors->toArray();
        }

        return $errors;
    }
}
