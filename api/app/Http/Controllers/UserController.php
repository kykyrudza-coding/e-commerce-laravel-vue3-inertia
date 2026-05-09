<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    public function index(Request $request)
    {
        return new UserResource($request->user()->load('orders'));
    }

    public function update(UserUpdateRequest $request)
    {
        $request->user()->update($request->validated());

        return new UserResource($request->user()->refresh());
    }
}
