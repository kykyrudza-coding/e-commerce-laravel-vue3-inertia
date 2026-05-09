<?php

namespace App\Http\Controllers;

use App\Actions\Order\AddAddressRenderAction;
use App\Actions\Order\AddAddressStoreAction;
use App\Actions\Order\ConfirmationAction;
use App\Actions\Order\CreateUserRenderAction;
use App\Actions\Order\CreateUserStoreAction;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(CreateUserRenderAction $action, $token)
    {
        return $action->createUserRenderAction($token);
    }

    public function store(Request $request, CreateUserStoreAction $action, $token)
    {
        return $action->createUserStoreAction($request, $token);
    }
    public function addAddress(AddAddressRenderAction $action, $token)
    {
       return $action->addAddressRenderAction($token);
    }
    public function storeAddAddress(AddAddressStoreAction $action, Request $request, $token)
    {
        return $action->addAddressStoreAction($request, $token);
    }
    public function confirmation(ConfirmationAction $action, $token)
    {
        return $action->confirmation($token);
    }
}
