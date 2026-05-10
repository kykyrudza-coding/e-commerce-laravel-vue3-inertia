<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private const SPECIFICATION_FILTERS = [
        'screenSize' => 'screen_size',
        'screenType' => 'screen_type',
        'os' => 'os',
        'processor' => 'processor',
        'ram' => 'ram',
        'storage' => 'storage',
        'cameraResolution' => 'camera_resolution',
        'batteryCapacity' => 'battery_capacity',
        'color' => 'color',
        'condition' => 'condition',
    ];

    private const SPECIFICATION_LABELS = [
        'screen_size' => 'Screen Size',
        'screen_type' => 'Screen Type',
        'os' => 'OS',
        'processor' => 'Processor',
        'ram' => 'RAM',
        'storage' => 'Storage',
        'camera_resolution' => 'Camera Resolution',
        'battery_capacity' => 'Battery Capacity',
        'color' => 'Color',
        'condition' => 'Condition',
    ];

    public function index(Request $request): JsonResponse
    {
        $query = Product::query()
            ->with(['category:id,name,slug', 'brand:id,name', 'images', 'main_image']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        } elseif ($request->filled('deviceType')) {
            $this->applyRelationFilter($query, 'category', $request->input('deviceType'));
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        } elseif ($request->filled('brand')) {
            $this->applyRelationFilter($query, 'brand', $request->input('brand'));
        }

        foreach (self::SPECIFICATION_FILTERS as $filterKey => $specificationKey) {
            if ($request->filled($filterKey)) {
                $this->applySpecificationFilter($query, $specificationKey, $request->input($filterKey));
            }
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('priceMin')) {
            $query->where('price', '>=', $request->input('priceMin'));
        }

        if ($request->filled('priceMax')) {
            $query->where('price', '<=', $request->input('priceMax'));
        }

        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction') === 'asc' ? 'asc' : 'desc';

        if (!in_array($sort, ['created_at', 'name', 'price', 'stock'], true)) {
            $sort = 'created_at';
        }

        $products = $query
            ->orderBy($sort, $direction)
            ->paginate($request->integer('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection($products),
            'filters' => $this->filters(),
            'domain' => config('app.url'),
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'specifications' => ['nullable', 'array'],
            'specifications.*' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] ??= Str::slug($data['name']);
        $data['stock'] ??= 0;
        $data['specifications'] = $this->normalizeSpecifications($data['specifications'] ?? []);

        $product = Product::query()->create($data);

        $product->load(['category', 'brand', 'images', 'main_image']);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product),
        ]);
    }

    public function show(string $product): JsonResponse
    {
        $product = $this->findProduct($product);

        $product->load([
            'images',
            'main_image',
            'category',
            'brand',
            'reviews.user',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product),
            'characteristics' => $this->characteristics($product),
            'domain' => config('app.url'),
        ]);
    }

    public function update(Request $request, string $product): JsonResponse
    {
        $product = $this->findProduct($product);

        $data = $request->validate([
            'category_id' => ['sometimes', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:255', 'unique:products,name,' . $product->id],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'slug' => ['sometimes', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'brand_id' => ['sometimes', 'nullable', 'exists:brands,id'],
            'specifications' => ['sometimes', 'nullable', 'array'],
            'specifications.*' => ['nullable', 'string', 'max:255'],
        ]);

        if (array_key_exists('name', $data) && !array_key_exists('slug', $data)) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (array_key_exists('specifications', $data)) {
            $data['specifications'] = $this->normalizeSpecifications(
                array_merge($product->specifications ?? [], $data['specifications'] ?? [])
            );
        }

        $product->update($data);

        $product->refresh()->load(['category', 'brand', 'images', 'main_image']);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ]);
    }

    public function destroy(string $product): JsonResponse
    {
        $product = $this->findProduct($product);

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'data' => null,
        ]);
    }

    public function reviewAdd(Request $request, string $product): JsonResponse
    {
        $product = $this->findProduct($product);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required_without:review', 'string', 'max:5000'],
            'review' => ['required_without:comment', 'string', 'max:5000'],
        ]);

        $review = Review::query()->create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'rating' => $data['rating'],
            'review' => $data['review'] ?? $data['comment'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Review added successfully',
            'data' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->review,
                'review' => $review->review,
                'user' => $review->load('user')->user,
                'created_at' => $review->created_at,
            ],
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->query('query');

        if (!$search) {
            return response()->json([
                'status' => 'success',
                'message' => 'Search results fetched successfully',
                'data' => [],
            ]);
        }

        $results = Product::query()
            ->where(function ($query) use ($search): void {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->select('id', 'name', 'description', 'slug')
            ->limit(15)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Search results fetched successfully',
            'data' => $results,
        ]);
    }

    private function findProduct(string $product): Product
    {
        return Product::query()
            ->where(function ($query) use ($product): void {
                $query
                    ->where('id', $product)
                    ->orWhere('slug', $product);
            })
            ->firstOrFail();
    }

    private function filters(): array
    {
        $filters = [
            'deviceType' => Category::query()->orderBy('name')->pluck('name')->values(),
            'brand' => Brand::query()->orderBy('name')->pluck('name')->values(),
        ];

        foreach (self::SPECIFICATION_FILTERS as $filterKey => $specificationKey) {
            $filters[$filterKey] = $this->specificationValues($specificationKey);
        }

        return $filters;
    }

    private function characteristics(Product $product): array
    {
        $characteristics = [
            'category' => [
                'name' => 'Category',
                'value' => $product->category->name ?? 'N/A',
            ],
            'brand' => [
                'name' => 'Brand',
                'value' => $product->brand->name ?? 'N/A',
            ],
        ];

        foreach (self::SPECIFICATION_LABELS as $key => $label) {
            $characteristics[$key] = [
                'name' => $label,
                'value' => $product->specifications[$key] ?? 'N/A',
            ];
        }

        return $characteristics;
    }

    private function applyRelationFilter($query, string $relation, mixed $values): void
    {
        $values = array_filter((array) $values, fn ($value) => $value !== null && $value !== '');

        if ($values === []) {
            return;
        }

        $query->whereHas($relation, function ($relationQuery) use ($values): void {
            $relationQuery->whereIn('name', $values);

            $ids = array_filter($values, fn ($value) => is_numeric($value));

            if ($ids !== []) {
                $relationQuery->orWhereIn('id', $ids);
            }
        });
    }

    private function applySpecificationFilter($query, string $key, mixed $values): void
    {
        $values = array_filter((array) $values, fn ($value) => $value !== null && $value !== '');

        if ($values === []) {
            return;
        }

        $query->where(function ($builder) use ($key, $values): void {
            foreach ($values as $value) {
                $builder->orWhere("specifications->{$key}", $value);
            }
        });
    }

    private function specificationValues(string $key): array
    {
        return Product::query()
            ->pluck('specifications')
            ->map(function ($specifications) use ($key) {
                if (is_string($specifications)) {
                    $specifications = json_decode($specifications, true);
                }

                return is_array($specifications) ? ($specifications[$key] ?? null) : null;
            })
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->unique()
            ->sort(SORT_NATURAL)
            ->values()
            ->all();
    }

    private function normalizeSpecifications(array $specifications): array
    {
        $allowedKeys = array_values(self::SPECIFICATION_FILTERS);

        return collect($specifications)
            ->only($allowedKeys)
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->map(fn ($value) => (string) $value)
            ->all();
    }
}
