<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordStoreRequest;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function store(ForgotPasswordStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if ($user) {
            $token = Password::createToken($user);

            Mail::to($user->email)
                ->send(new ResetPasswordEmail(
                    user: $user,
                    token: $token,
                ));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'If the account exists, a reset email has been sent.',
            'data' => null,
        ]);
    }
}
