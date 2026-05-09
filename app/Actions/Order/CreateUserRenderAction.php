<?php

namespace App\Actions\Order;

use App\Actions\GetAnonymousUserId;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

class CreateUserRenderAction
{
    protected GetAnonymousUserId $getAnonymousUserId;

    public function __construct(GetAnonymousUserId $getAnonymousUserId)
    {
        $this->getAnonymousUserId = $getAnonymousUserId;
    }
    public function createUserRenderAction($token): SymphonyResponse|InertiaResponse|RedirectResponse
    {
        $user_id = auth()->check() ? auth()->id() : $this->getAnonymousUserId->getAnonymousUserId();

        $cartItem = session('cart_' . $user_id, []);

        if (empty($cartItem)) {
            return Inertia::location(route('cart.index', $user_id));
        }

        $products = collect($cartItem)->map(function ($item) {
            return Product::with('main_image')->find($item['product_id']);
        });

        if ($products->isEmpty()) {
            return redirect()->route('home');
        }

        if ($token != session('orderToken')) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Order/Index', [
            'contactInfo' => true,
            'addAddress' => false,
            'confirmOrder' => false,
            'products' => $products,
            'token' => $token,
            'user' => auth()->user() ?? session('checkout_user', []),
        ]);
    }
}
