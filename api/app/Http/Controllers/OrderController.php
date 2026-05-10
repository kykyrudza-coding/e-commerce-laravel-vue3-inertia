<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $order = Order::query()
            ->with(['items.product', 'delivery_address'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => OrderResource::collection($order),
            'pagination' => [
                'total' => $order->total(),
                'per_page' => $order->perPage(),
                'current_page' => $order->currentPage(),
                'last_page' => $order->lastPage(),
                'from' => $order->firstItem(),
                'to' => $order->lastItem(),
            ],
        ]);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        abort_unless(
            $order->user_id === $request->user()->id,
            Response::HTTP_FORBIDDEN
        );

        $order->load([
            'items.product',
            'delivery_address',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(OrderStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $order = DB::transaction(function () use ($request, $data) {
            $products = Product::query()
                ->whereIn('id', collect($data['items'])->pluck('product_id'))
                ->get()
                ->keyBy('id');

            $total = collect($data['items'])->sum(
                fn (array $item) => $products[$item['product_id']]->price * $item['quantity']
            );

            $order = Order::query()
                ->create([
                    'user_id' => $request->user()->id,
                    'order_token' => (string) Str::uuid(),
                    'status' => 'pending',
                    'payment_method' => $data['payment_method'] ?? 'manual',
                    'notes' => $data['notes'] ?? null,
                    'total_price' => $total,
                ]);

            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $products[$item['product_id']]->price,
                ]);
            }

            return $order;
        });

        $order->load([
            'items.product',
            'delivery_address',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => new OrderResource($order),
        ], Response::HTTP_CREATED);
    }
}
