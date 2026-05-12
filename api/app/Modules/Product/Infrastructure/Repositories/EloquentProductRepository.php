<?php

declare(strict_types=1);

namespace App\Modules\Product\Infrastructure\Repositories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Modules\Product\Application\Queries\ListProductsQuery;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Product\Domain\ValueObjects\ProductSpecifications;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginate(ListProductsQuery $query): LengthAwarePaginator
    {
        $builder = Product::query()
            ->with(['category:id,name,slug', 'brand:id,name', 'images', 'main_image']);

        $this->applyFilters($builder, $query->filters);

        $sort = $query->filters['sort'] ?? 'created_at';
        $direction = ($query->filters['direction'] ?? null) === 'asc' ? 'asc' : 'desc';

        if (! in_array($sort, ['created_at', 'name', 'price', 'stock'], true)) {
            $sort = 'created_at';
        }

        return $builder
            ->orderBy($sort, $direction)
            ->paginate($query->perPage);
    }

    public function findByIdentifier(string $identifier, array $with = []): Product
    {
        return Product::query()
            ->with($with)
            ->where(function (Builder $query) use ($identifier): void {
                $query
                    ->where('id', $identifier)
                    ->orWhere('slug', $identifier);
            })
            ->firstOrFail();
    }

    public function create(array $data): Product
    {
        $product = Product::query()->create($data);

        return $product->load(['category', 'brand', 'images', 'main_image']);
    }

    public function update(string $identifier, array $data): Product
    {
        $product = $this->findByIdentifier($identifier);
        $product->update($data);

        return $product->refresh()->load(['category', 'brand', 'images', 'main_image']);
    }

    public function delete(string $identifier): void
    {
        $this->findByIdentifier($identifier)->delete();
    }

    public function search(?string $term): Collection
    {
        if (! $term) {
            return collect();
        }

        return Product::query()
            ->where(function (Builder $query) use ($term): void {
                $query
                    ->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            })
            ->select('id', 'name', 'description', 'slug')
            ->limit(15)
            ->get();
    }

    public function filters(): array
    {
        $filters = [
            'deviceType' => Category::query()->orderBy('name')->pluck('name')->values(),
            'brand' => Brand::query()->orderBy('name')->pluck('name')->values(),
        ];

        foreach (ProductSpecifications::FILTERS as $filterKey => $specificationKey) {
            $filters[$filterKey] = $this->specificationValues($specificationKey);
        }

        return $filters;
    }

    public function characteristics(Product $product): array
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

        foreach (ProductSpecifications::LABELS as $key => $label) {
            $characteristics[$key] = [
                'name' => $label,
                'value' => $product->specifications[$key] ?? 'N/A',
            ];
        }

        return $characteristics;
    }

    public function createReview(int $productId, int $userId, int $rating, string $review): Review
    {
        $review = Review::query()->create([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $rating,
            'review' => $review,
        ]);

        return $review->load('user');
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        } elseif (! empty($filters['deviceType'])) {
            $this->applyRelationFilter($query, 'category', $filters['deviceType']);
        }

        if (! empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        } elseif (! empty($filters['brand'])) {
            $this->applyRelationFilter($query, 'brand', $filters['brand']);
        }

        foreach (ProductSpecifications::FILTERS as $filterKey => $specificationKey) {
            if (! empty($filters[$filterKey])) {
                $this->applySpecificationFilter($query, $specificationKey, $filters[$filterKey]);
            }
        }

        if (! empty($filters['search'])) {
            $search = (string) $filters['search'];

            $query->where(function (Builder $builder) use ($search): void {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (array_key_exists('priceMin', $filters) && $filters['priceMin'] !== null && $filters['priceMin'] !== '') {
            $query->where('price', '>=', $filters['priceMin']);
        }

        if (array_key_exists('priceMax', $filters) && $filters['priceMax'] !== null && $filters['priceMax'] !== '') {
            $query->where('price', '<=', $filters['priceMax']);
        }
    }

    private function applyRelationFilter(Builder $query, string $relation, mixed $values): void
    {
        $values = array_filter((array) $values, fn ($value): bool => $value !== null && $value !== '');

        if ($values === []) {
            return;
        }

        $query->whereHas($relation, function (Builder $relationQuery) use ($values): void {
            $relationQuery->whereIn('name', $values);

            $ids = array_filter($values, fn ($value): bool => is_numeric($value));

            if ($ids !== []) {
                $relationQuery->orWhereIn('id', $ids);
            }
        });
    }

    private function applySpecificationFilter(Builder $query, string $key, mixed $values): void
    {
        $values = array_filter((array) $values, fn ($value): bool => $value !== null && $value !== '');

        if ($values === []) {
            return;
        }

        $query->where(function (Builder $builder) use ($key, $values): void {
            foreach ($values as $value) {
                $builder->orWhere("specifications->{$key}", $value);
            }
        });
    }

    private function specificationValues(string $key): array
    {
        return Product::query()
            ->select('specifications')
            ->get()
            ->map(function (Product $product) use ($key) {
                $specifications = $product->specifications;

                if (is_string($specifications)) {
                    $specifications = json_decode($specifications, true);
                }

                return is_array($specifications) ? ($specifications[$key] ?? null) : null;
            })
            ->filter(fn ($value): bool => $value !== null && $value !== '')
            ->unique()
            ->sort(SORT_NATURAL)
            ->values()
            ->all();
    }
}
