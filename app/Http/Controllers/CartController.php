<?php

namespace App\Http\Controllers;

use App\Actions\Cart\CartAction;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index(CartAction $action)
    {
        return $action->render_cart();
    }

    public function store(CartAction $action, $product_slug)
    {
        return $action->add_to_cart($product_slug);
    }

    public function delete($product_slug)
    {
        $product = Product::where('slug', $product_slug)->firstOrFail();

        $user_id = auth()->id();

        Cart::where('user_id', $user_id)->where('product_id', $product->id)->delete();

        return Inertia::location(route('cart.index', ['user_id' => $user_id]));
    }
}
