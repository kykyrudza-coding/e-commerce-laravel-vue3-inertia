<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = Cart::query()
            ->with(['product.main_image', 'product.category'])
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => CartResource::collection($items),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::query()->findOrFail($data['product_id']);

        $cartItem = Cart::query()->firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = $cartItem->exists
            ? $cartItem->quantity + ($data['quantity'] ?? 1)
            : ($data['quantity'] ?? 1);

        $cartItem->save();

        $cartItem->load(['product.main_image', 'product.category']);

        return response()->json([
            'status' => 'success',
            'data' => new CartResource($cartItem),
        ]);
    }

    public function update(Request $request, Cart $item): JsonResponse
    {
        abort_unless(
            $item->user_id === $request->user()->id,
            Response::HTTP_FORBIDDEN
        );

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item->update($data);

        $item->load(['product.main_image', 'product.category']);

        return response()->json([
            'status' => 'success',
            'data' => new CartResource($item),
        ]);
    }

    public function destroy(Request $request, Cart $item): JsonResponse
    {
        abort_unless(
            $item->user_id === $request->user()->id,
            Response::HTTP_FORBIDDEN
        );

        $item->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function clear(Request $request): JsonResponse
    {
        Cart::query()
            ->where('user_id', $request->user()->id)
            ->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
