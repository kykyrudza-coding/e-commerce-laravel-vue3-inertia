<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $response = Password::reset(
            $request->validated(),
            function ($user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($response !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => trans($response),
            'data' => null,
        ]);
    }
}
