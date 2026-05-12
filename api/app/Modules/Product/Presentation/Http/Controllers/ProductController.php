<?php

declare(strict_types=1);

namespace App\Modules\Product\Presentation\Http\Controllers;

use App\Enums\HttpCodeEnum;
use App\Http\Controllers\Controller;
use App\Modules\Product\Application\Commands\DeleteProductCommand;
use App\Modules\Product\Application\Handlers\AddProductReviewHandler;
use App\Modules\Product\Application\Handlers\CreateProductHandler;
use App\Modules\Product\Application\Handlers\DeleteProductHandler;
use App\Modules\Product\Application\Handlers\UpdateProductHandler;
use App\Modules\Product\Application\Queries\ListProductsQuery;
use App\Modules\Product\Application\Queries\SearchProductsQuery;
use App\Modules\Product\Application\Queries\ShowProductQuery;
use App\Modules\Product\Application\QueryHandlers\ListProductsHandler;
use App\Modules\Product\Application\QueryHandlers\SearchProductsHandler;
use App\Modules\Product\Application\QueryHandlers\ShowProductHandler;
use App\Modules\Product\Presentation\Http\Requests\AddProductReviewRequest;
use App\Modules\Product\Presentation\Http\Requests\StoreProductRequest;
use App\Modules\Product\Presentation\Http\Requests\UpdateProductRequest;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ListProductsHandler $handler): JsonResponse
    {
        $result = $handler->handle(new ListProductsQuery(
            filters: $request->query(),
            perPage: $request->integer('per_page', 15),
        ));

        return ApiResponse::success(
            data: $result->data(),
            message: 'Products fetched successfully.',
            meta: $result->meta(),
        );
    }

    public function store(StoreProductRequest $request, CreateProductHandler $handler): JsonResponse
    {
        $product = $handler->handle($request->toCommand());

        return ApiResponse::success(
            data: $product->toArray(),
            message: 'Product created successfully.',
            code: HttpCodeEnum::CREATED,
        );
    }

    public function show(string $product, ShowProductHandler $handler): JsonResponse
    {
        $result = $handler->handle(new ShowProductQuery($product));

        return ApiResponse::success(
            data: $result->data(),
            message: 'Product fetched successfully.',
            meta: $result->meta(),
        );
    }

    public function update(UpdateProductRequest $request, UpdateProductHandler $handler): JsonResponse
    {
        $product = $handler->handle($request->toCommand());

        return ApiResponse::success(
            data: $product->toArray(),
            message: 'Product updated successfully.',
        );
    }

    public function destroy(string $product, DeleteProductHandler $handler): JsonResponse
    {
        $handler->handle(new DeleteProductCommand($product));

        return ApiResponse::success(
            message: 'Product deleted successfully.',
        );
    }

    public function reviewAdd(AddProductReviewRequest $request, AddProductReviewHandler $handler): JsonResponse
    {
        $review = $handler->handle($request->toCommand());

        return ApiResponse::success(
            data: $review->toArray(),
            message: 'Review added successfully.',
            code: HttpCodeEnum::CREATED,
        );
    }

    public function search(Request $request, SearchProductsHandler $handler): JsonResponse
    {
        $results = $handler->handle(new SearchProductsQuery($request->query('query')));

        return ApiResponse::success(
            data: $results,
            message: 'Search results fetched successfully.',
        );
    }
}
