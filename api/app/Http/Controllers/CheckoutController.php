<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CheckoutStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * @throws Throwable
     */
    public function store(CheckoutStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $cartItems = Cart::query()
            ->with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your cart is empty.',
                'data' => null,
            ]);
        }

        $order = DB::transaction(function () use ($data, $user, $cartItems) {
            $order = Order::query()
                ->create([
                    'user_id' => $user->id,
                    'order_token' => (string) Str::uuid(),
                    'status' => 'pending',
                    'payment_method' => $data['payment_method'] ?? 'manual',
                    'notes' => $data['notes'] ?? null,
                    'total_price' => $cartItems->sum(
                        fn ($item) => $item->product->price * $item->quantity
                    ),
                ]);

            foreach ($cartItems as $item) {
                $order->items()
                    ->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);
            }

            Cart::query()
                ->where('user_id', $user->id)
                ->delete();

            return $order;
        });

        $order->load([
            'items.product',
            'delivery_address',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ]);
    }
}
