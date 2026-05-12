<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

function createOrderModuleUser(string $email = 'order-user@example.com'): User
{
    return User::query()->create([
        'name' => 'Order User',
        'email' => $email,
        'phone' => '099-666-6666',
        'password' => Hash::make('password123'),
    ]);
}

function createOrderModuleProduct(string $name = 'Order Product', float $price = 100): Product
{
    $category = Category::query()->create([
        'name' => $name . ' Category',
        'slug' => str($name)->slug() . '-category',
    ]);

    return Product::query()->create([
        'category_id' => $category->id,
        'name' => $name,
        'description' => 'Order module product',
        'price' => $price,
        'stock' => 10,
        'slug' => str($name)->slug(),
    ]);
}

it('lists current user orders through the order query handler', function () {
    $user = createOrderModuleUser();
    $otherUser = createOrderModuleUser('other-order-user@example.com');
    $product = createOrderModuleProduct();

    $order = Order::query()->create([
        'user_id' => $user->id,
        'order_token' => 'order-token-1',
        'status' => 'pending',
        'payment_method' => 'manual',
        'total_price' => 100,
    ]);
    $order->items()->create([
        'product_id' => $product->id,
        'quantity' => 1,
        'price' => 100,
    ]);

    Order::query()->create([
        'user_id' => $otherUser->id,
        'order_token' => 'order-token-2',
        'status' => 'pending',
        'payment_method' => 'manual',
        'total_price' => 200,
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/orders');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.0.order_token', 'order-token-1')
        ->assertJsonPath('meta.total', 1)
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors',
            'meta' => ['total', 'per_page', 'current_page', 'last_page'],
        ]);
});

it('shows only an order owned by the current user', function () {
    $user = createOrderModuleUser();
    $product = createOrderModuleProduct();

    $order = Order::query()->create([
        'user_id' => $user->id,
        'order_token' => 'owned-order-token',
        'status' => 'pending',
        'payment_method' => 'manual',
        'total_price' => 300,
    ]);
    $order->items()->create([
        'product_id' => $product->id,
        'quantity' => 3,
        'price' => 100,
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson("/api/orders/{$order->id}");

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.order_token', 'owned-order-token')
        ->assertJsonPath('data.items.0.quantity', 3);
});

it('rejects access to another user order with the shared api envelope', function () {
    $user = createOrderModuleUser();
    $otherUser = createOrderModuleUser('order-owner@example.com');

    $order = Order::query()->create([
        'user_id' => $otherUser->id,
        'order_token' => 'forbidden-order-token',
        'status' => 'pending',
        'payment_method' => 'manual',
        'total_price' => 100,
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson("/api/orders/{$order->id}");

    $response
        ->assertForbidden()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'You do not have access to this order.');
});

it('creates an order through the order command pipeline', function () {
    $user = createOrderModuleUser();
    $firstProduct = createOrderModuleProduct('First Order Product', 125);
    $secondProduct = createOrderModuleProduct('Second Order Product', 75);

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/orders', [
        'items' => [
            ['product_id' => $firstProduct->id, 'quantity' => 2],
            ['product_id' => $secondProduct->id, 'quantity' => 1],
        ],
        'payment_method' => 'manual',
        'notes' => 'Leave at door',
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Order created successfully.')
        ->assertJsonPath('data.total_price', 325)
        ->assertJsonPath('data.items.0.quantity', 2)
        ->assertJsonPath('data.notes', 'Leave at door');
});

it('returns the shared validation envelope for invalid order input', function () {
    $user = createOrderModuleUser();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/orders', [
        'items' => [],
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Validation failed.')
        ->assertJsonStructure([
            'errors' => ['items'],
        ]);
});
