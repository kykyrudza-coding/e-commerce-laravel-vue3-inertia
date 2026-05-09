<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    public function createPayment(Request $request)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
        ]);

        $order = Order::where('user_id', $request->user()->id)->findOrFail($data['order_id']);

        return response()->json([
            'data' => [
                'order_id' => $order->id,
                'provider' => 'paypal',
                'approval_url' => null,
                'status' => 'created',
            ],
        ], 201);
    }

    public function executePayment(Request $request)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'transaction_id' => ['nullable', 'string'],
        ]);

        $order = Order::where('user_id', $request->user()->id)->findOrFail($data['order_id']);
        $order->update([
            'transaction_id' => $data['transaction_id'] ?? null,
            'status' => 'paid',
        ]);

        return response()->json(['data' => $order]);
    }
}
