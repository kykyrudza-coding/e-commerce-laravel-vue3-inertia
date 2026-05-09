<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(
            Category::query()->with('children')->whereNull('parent_id')->get()
        );
    }

    public function show(string $category)
    {
        $category = Category::query()
            ->with(['children', 'parent'])
            ->where('id', $category)
            ->orWhere('slug', $category)
            ->firstOrFail();

        return new CategoryResource($category);
    }

    public function products(string $category)
    {
        $category = Category::query()
            ->with('children')
            ->where('id', $category)
            ->orWhere('slug', $category)
            ->firstOrFail();

        $categoryIds = $category->children->pluck('id')->push($category->id);

        return ProductResource::collection(
            Product::query()
                ->with(['category:id,name,slug', 'images', 'main_image'])
                ->whereIn('category_id', $categoryIds)
                ->paginate(15)
        )->additional(['category' => new CategoryResource($category)]);
    }
}
