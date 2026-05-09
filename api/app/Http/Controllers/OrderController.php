<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return OrderResource::collection(
            Order::query()
                ->with(['items.product', 'delivery_address'])
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(15)
        );
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, Response::HTTP_FORBIDDEN);

        return new OrderResource($order->load(['items.product', 'delivery_address']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $products = Product::whereIn('id', collect($data['items'])->pluck('product_id'))->get()->keyBy('id');
        $total = collect($data['items'])->sum(fn ($item) => $products[$item['product_id']]->price * $item['quantity']);

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_token' => (string) Str::uuid(),
            'status' => 'pending',
            'payment_method' => $data['payment_method'] ?? 'manual',
            'notes' => $data['notes'] ?? null,
            'total_price' => $total,
        ]);

        foreach ($data['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $products[$item['product_id']]->price,
            ]);
        }

        return (new OrderResource($order->load(['items.product', 'delivery_address'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
