<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class CartAction
{
    public function render_cart(): \Inertia\Response
    {
        $user_id = auth()->id();

        $cart = Cart::where('user_id', $user_id)->pluck('product_id');

        $products = Product::whereIn('id', $cart)->with('main_image')->get();

        $categories = $products->map(function($product) {
            return [
                'name' => $product->category->name,
                'value' => $product->category->name,
            ];
        });

        return Inertia::render('Cart/Index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function add_to_cart($product_id): \Illuminate\Http\RedirectResponse
    {
        $product = Product::findOrFail($product_id);

        $user_id = auth()->id();

        $cartItem = Cart::where('user_id', $user_id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'product_id' => $product->id,
                'user_id'    => $user_id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Товар додано до кошика');
    }

}
