<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return CartResource::collection(
            Cart::query()
                ->with(['product.main_image', 'product.category'])
                ->where('user_id', $request->user()->id)
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        $cartItem = Cart::firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = $cartItem->exists
            ? $cartItem->quantity + ($data['quantity'] ?? 1)
            : ($data['quantity'] ?? 1);
        $cartItem->save();

        return (new CartResource($cartItem->load(['product.main_image', 'product.category'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, Cart $item)
    {
        abort_unless($item->user_id === $request->user()->id, Response::HTTP_FORBIDDEN);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item->update($data);

        return new CartResource($item->load(['product.main_image', 'product.category']));
    }

    public function destroy(Request $request, Cart $item)
    {
        abort_unless($item->user_id === $request->user()->id, Response::HTTP_FORBIDDEN);

        $item->delete();

        return response()->noContent();
    }

    public function clear(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return response()->noContent();
    }
}
