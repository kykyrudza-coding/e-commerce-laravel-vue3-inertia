<?php

declare(strict_types=1);

namespace App\Modules\Order\Presentation\Http\Controllers;

use App\Enums\HttpCodeEnum;
use App\Http\Controllers\Controller;
use App\Modules\Order\Application\Handlers\CreateOrderHandler;
use App\Modules\Order\Application\Queries\ListOrdersQuery;
use App\Modules\Order\Application\Queries\ShowOrderQuery;
use App\Modules\Order\Application\QueryHandlers\ListOrdersHandler;
use App\Modules\Order\Application\QueryHandlers\ShowOrderHandler;
use App\Modules\Order\Domain\Exceptions\OrderAccessDeniedException;
use App\Modules\Order\Presentation\Http\Requests\StoreOrderRequest;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, ListOrdersHandler $handler): JsonResponse
    {
        $result = $handler->handle(new ListOrdersQuery(
            userId: (int) $request->user()->id,
            perPage: $request->integer('per_page', 15),
        ));

        return ApiResponse::success(
            data: $result->data(),
            message: 'Orders fetched successfully.',
            meta: $result->meta(),
        );
    }

    public function show(Request $request, string $order, ShowOrderHandler $handler): JsonResponse
    {
        try {
            $result = $handler->handle(new ShowOrderQuery(
                orderId: (int) $order,
                userId: (int) $request->user()->id,
            ));
        } catch (OrderAccessDeniedException $exception) {
            return ApiResponse::error(
                message: $exception->getMessage(),
                code: HttpCodeEnum::FORBIDDEN,
            );
        }

        return ApiResponse::success(
            data: $result->toArray(),
            message: 'Order fetched successfully.',
        );
    }

    public function store(StoreOrderRequest $request, CreateOrderHandler $handler): JsonResponse
    {
        $order = $handler->handle($request->toCommand());

        return ApiResponse::success(
            data: $order->toArray(),
            message: 'Order created successfully.',
            code: HttpCodeEnum::CREATED,
        );
    }
}
