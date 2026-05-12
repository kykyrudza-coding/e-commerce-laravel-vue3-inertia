<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function createProductModuleCategory(): Category
{
    return Category::query()->create([
        'name' => 'Phones',
        'slug' => 'phones',
    ]);
}

function createProductModuleBrand(): Brand
{
    return Brand::query()->create([
        'name' => 'Acme',
    ]);
}

it('lists products through the product query handler', function () {
    $category = createProductModuleCategory();
    $brand = createProductModuleBrand();

    Product::query()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'name' => 'Acme Phone',
        'description' => 'A test phone',
        'price' => 499.99,
        'stock' => 10,
        'slug' => 'acme-phone',
        'specifications' => ['color' => 'black'],
    ]);

    Product::query()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'name' => 'No Specs Phone',
        'description' => 'A product without specifications',
        'price' => 199.99,
        'stock' => 4,
        'slug' => 'no-specs-phone',
        'specifications' => null,
    ]);

    $response = $this->getJson('/api/products');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.0.name', 'Acme Phone')
        ->assertJsonPath('meta.filters.brand.0', 'Acme')
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors',
            'meta' => ['total', 'per_page', 'current_page', 'last_page', 'filters', 'domain'],
        ]);
});

it('shows a product with characteristics in response meta', function () {
    $category = createProductModuleCategory();
    $brand = createProductModuleBrand();

    Product::query()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'name' => 'Detail Phone',
        'description' => 'Detailed phone',
        'price' => 599.99,
        'stock' => 5,
        'slug' => 'detail-phone',
        'specifications' => ['screen_size' => '6.1'],
    ]);

    $response = $this->getJson('/api/products/detail-phone');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.slug', 'detail-phone')
        ->assertJsonPath('meta.characteristics.screen_size.value', '6.1');
});

it('creates a product through the product command pipeline', function () {
    $category = createProductModuleCategory();
    $brand = createProductModuleBrand();

    $response = $this->postJson('/api/products', [
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'name' => 'Pipeline Phone',
        'description' => 'Created by pipeline',
        'price' => 799.99,
        'stock' => 7,
        'specifications' => [
            'screen_size' => '6.7',
            'unsupported' => 'ignored',
        ],
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.slug', 'pipeline-phone')
        ->assertJsonPath('data.specifications.screen_size', '6.7')
        ->assertJsonMissingPath('data.specifications.unsupported');
});

it('updates a product through the product command pipeline', function () {
    $category = createProductModuleCategory();

    $product = Product::query()->create([
        'category_id' => $category->id,
        'name' => 'Old Product',
        'description' => 'Old description',
        'price' => 100,
        'stock' => 1,
        'slug' => 'old-product',
        'specifications' => ['color' => 'black'],
    ]);

    $response = $this->putJson("/api/products/{$product->id}", [
        'name' => 'New Product',
        'price' => 150,
        'specifications' => ['screen_size' => '6.2'],
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.name', 'New Product')
        ->assertJsonPath('data.slug', 'new-product')
        ->assertJsonPath('data.specifications.color', 'black')
        ->assertJsonPath('data.specifications.screen_size', '6.2');
});

it('searches products through the product query handler', function () {
    $category = createProductModuleCategory();

    Product::query()->create([
        'category_id' => $category->id,
        'name' => 'Searchable Laptop',
        'description' => 'Powerful machine',
        'price' => 999,
        'stock' => 3,
        'slug' => 'searchable-laptop',
    ]);

    $response = $this->getJson('/api/search?query=Laptop');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.0.slug', 'searchable-laptop');
});

it('adds a product review through the product command handler', function () {
    $category = createProductModuleCategory();
    $user = User::query()->create([
        'name' => 'Review User',
        'email' => 'reviewer@example.com',
        'phone' => '099-555-5555',
        'password' => Hash::make('password123'),
    ]);

    $product = Product::query()->create([
        'category_id' => $category->id,
        'name' => 'Review Product',
        'description' => 'Reviewed product',
        'price' => 199,
        'stock' => 4,
        'slug' => 'review-product',
    ]);

    Sanctum::actingAs($user);

    $response = $this->postJson("/api/products/{$product->id}/reviews", [
        'rating' => 5,
        'comment' => 'Great product',
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.rating', 5)
        ->assertJsonPath('data.comment', 'Great product');
});
