<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user()->load('orders');

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user),
        ]);
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $request->user()->update($validated);

        $user = $request->user()->refresh();

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user),
        ]);
    }
}
