<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('checks out cart items without requiring a payment method', function () {
    $user = User::query()->create([
        'name' => 'Checkout User',
        'email' => 'checkout-user@example.com',
        'phone' => '099-777-7777',
        'password' => Hash::make('password123'),
    ]);

    $category = Category::query()->create([
        'name' => 'Checkout Category',
        'slug' => 'checkout-category',
    ]);

    $product = Product::query()->create([
        'category_id' => $category->id,
        'name' => 'Checkout Product',
        'description' => 'Checkout product description',
        'price' => 50,
        'stock' => 5,
        'slug' => 'checkout-product',
    ]);

    Cart::query()->create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/checkout');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Order created successfully.')
        ->assertJsonPath('data.payment_method', 'manual')
        ->assertJsonPath('data.total_price', 100)
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors',
            'meta',
        ]);

    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'payment_method' => 'manual',
        'total_price' => 100,
    ]);

    $this->assertDatabaseMissing('cart_items', [
        'user_id' => $user->id,
        'product_id' => $product->id,
    ]);
});
