<?php

namespace App\Actions\Order;

use Inertia\Inertia;
use Inertia\Response;

class ConfirmationAction
{
    public function confirmation($token): Response
    {
        $user = auth()->user() ?? session('checkout_user');
        $data = session('data');
        $method = session('method');
        $products = session('products');

        return Inertia::render('Order/Index', [
            'contactInfo' => false,
            'addAddress' => false,
            'confirmOrder' => true,
            'products' => $products,
            'token' => $token,
            'method' => $method,
            'data' => $data,
            'user' => $user,
        ]);
    }
}
