<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $cartItems = Cart::query()
            ->with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        abort_if($cartItems->isEmpty(), Response::HTTP_UNPROCESSABLE_ENTITY, 'Cart is empty.');

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_token' => (string) Str::uuid(),
            'status' => 'pending',
            'payment_method' => $request->input('payment_method', 'manual'),
            'notes' => $request->input('notes'),
            'total_price' => $cartItems->sum(fn ($item) => $item->product->price * $item->quantity),
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Cart::where('user_id', $request->user()->id)->delete();

        return (new OrderResource($order->load(['items.product', 'delivery_address'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
