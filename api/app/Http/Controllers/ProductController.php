<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\BatteryCapacity;
use App\Models\Brand;
use App\Models\CameraResolution;
use App\Models\Category;
use App\Models\Color;
use App\Models\Condition;
use App\Models\OperatingSystem;
use App\Models\Processor;
use App\Models\Product;
use App\Models\Ram;
use App\Models\Review;
use App\Models\ScreenType;
use App\Models\Size;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filterMapping = [
            'deviceType' => 'category_id',
            'category_id' => 'category_id',
            'brand' => 'brand_id',
            'brand_id' => 'brand_id',
            'screenSize' => 'screen_size_id',
            'screenType' => 'screen_type_id',
            'os' => 'os_id',
            'processor' => 'processor_id',
            'ram' => 'ram_id',
            'storage' => 'storage_id',
            'cameraResolution' => 'camera_resolution_id',
            'batteryCapacity' => 'battery_capacity_id',
            'color' => 'color_id',
            'condition' => 'condition_id',
        ];

        $query = Product::query()->with(['category:id,name,slug', 'images', 'main_image']);

        foreach ($filterMapping as $filterKey => $column) {
            if ($request->filled($filterKey)) {
                $values = $request->input($filterKey);
                is_array($values)
                    ? $query->whereIn($column, $values)
                    : $query->where($column, $values);
            }
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(fn ($builder) => $builder
                ->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        if ($request->filled('priceMin')) {
            $query->where('price', '>=', $request->input('priceMin'));
        }

        if ($request->filled('priceMax')) {
            $query->where('price', '<=', $request->input('priceMax'));
        }

        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc') === 'asc' ? 'asc' : 'desc';
        if (! in_array($sort, ['created_at', 'name', 'price', 'stock'], true)) {
            $sort = 'created_at';
        }

        return ProductResource::collection(
            $query->orderBy($sort, $direction)->paginate($request->integer('per_page', 15))
        )->additional([
            'filters' => $this->filters(),
            'domain' => config('app.url'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
        ]);

        $data['slug'] ??= Str::slug($data['name']);

        return (new ProductResource(Product::create($data)))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(string $product)
    {
        $product = Product::query()
            ->with([
                'images',
                'main_image',
                'category',
                'operatingSystem',
                'brand',
                'screenType',
                'processor',
                'ram',
                'storage',
                'camera_resolution',
                'battery_capacity',
                'color',
                'condition',
                'review.user',
            ])
            ->where('id', $product)
            ->orWhere('slug', $product)
            ->firstOrFail();

        return (new ProductResource($product))->additional([
            'characteristics' => $this->characteristics($product),
            'domain' => config('app.url'),
        ]);
    }

    public function update(Request $request, string $product)
    {
        $product = Product::where('id', $product)->orWhere('slug', $product)->firstOrFail();

        $data = $request->validate([
            'category_id' => ['sometimes', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:255', 'unique:products,name,'.$product->id],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'slug' => ['sometimes', 'string', 'max:255', 'unique:products,slug,'.$product->id],
        ]);

        $product->update($data);

        return new ProductResource($product->refresh());
    }

    public function destroy(string $product)
    {
        Product::where('id', $product)->orWhere('slug', $product)->firstOrFail()->delete();

        return response()->noContent();
    }

    public function reviewAdd(Request $request, string $product)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required_without:review', 'string', 'max:5000'],
            'review' => ['required_without:comment', 'string', 'max:5000'],
        ]);

        $product = Product::where('id', $product)->orWhere('slug', $product)->firstOrFail();

        $review = Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'rating' => $data['rating'],
            'review' => $data['review'] ?? $data['comment'],
        ]);

        return response()->json(['data' => $review->load('user')], Response::HTTP_CREATED);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json([
                'results' => []
            ]);
        }

        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'description', 'slug')
            ->limit(15)
            ->get();

        return response()->json([
            'results' => $results
        ]);
    }

    private function filters(): array
    {
        return [
            'deviceType' => Category::query()->select('id', 'name')->get(),
            'brand' => Brand::query()->select('id', 'name')->get(),
            'screenSize' => Size::query()->select('id', 'name')->get(),
            'screenType' => ScreenType::query()->select('id', 'name')->get(),
            'os' => OperatingSystem::query()->select('id', 'name')->get(),
            'processor' => Processor::query()->select('id', 'name')->get(),
            'ram' => Ram::query()->select('id', 'name')->get(),
            'storage' => Storage::query()->select('id', 'name')->get(),
            'cameraResolution' => CameraResolution::query()->select('id', 'name')->get(),
            'batteryCapacity' => BatteryCapacity::query()->select('id', 'battery_capacity as name')->get(),
            'color' => Color::query()->select('id', 'name')->get(),
            'condition' => Condition::query()->select('id', 'name')->get(),
        ];
    }

    private function characteristics(Product $product): array
    {
        return [
            'category' => ['name' => 'Category', 'value' => $product->category->name ?? 'N/A'],
            'os' => ['name' => 'OS', 'value' => $product->operatingSystem->name ?? 'N/A'],
            'brand' => ['name' => 'Brand', 'value' => $product->brand->name ?? 'N/A'],
            'screen_type' => ['name' => 'Screen Type', 'value' => $product->screenType->name ?? 'N/A'],
            'processor' => ['name' => 'Processor', 'value' => $product->processor->name ?? 'N/A'],
            'ram' => ['name' => 'RAM', 'value' => $product->ram->name ?? 'N/A'],
            'storage' => ['name' => 'Storage', 'value' => $product->storage->name ?? 'N/A'],
            'color' => ['name' => 'Color', 'value' => $product->color->name ?? 'N/A'],
            'condition' => ['name' => 'Condition', 'value' => $product->condition->name ?? 'N/A'],
        ];
    }
}
