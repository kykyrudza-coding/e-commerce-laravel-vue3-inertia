<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()
            ->with('children')
            ->whereNull('parent_id')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Categories fetched successfully',
            'data' => CategoryResource::collection($categories),
        ]);
    }

    public function show(string $category): JsonResponse
    {
        $category = Category::query()
            ->with(['children', 'parent'])
            ->where(function ($query) use ($category) {
                $query->where('id', $category)
                    ->orWhere('slug', $category);
            })
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'message' => 'Category fetched successfully',
            'data' => new CategoryResource($category),
        ]);
    }

    public function products(Category $category): JsonResponse
    {
        $category->load('children');

        $categoryIds = $category->children
            ->pluck('id')
            ->push($category->id);

        $products = Product::query()
            ->with(['category:id,name,slug', 'images', 'main_image'])
            ->whereIn('category_id', $categoryIds)
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
            'data' => [
                'products' => ProductResource::collection($products),
                'category' => new CategoryResource($category),
            ]
        ]);
    }
}
