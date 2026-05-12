<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('returns the current user profile through the profile query handler', function () {
    $user = User::query()->create([
        'name' => 'Profile User',
        'email' => 'profile@example.com',
        'phone' => '099-111-1111',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/user');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.email', 'profile@example.com')
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['id', 'name', 'email', 'phone', 'address', 'created_at', 'updated_at'],
            'errors',
            'meta',
        ]);
});

it('returns profile details through the profile query handler', function () {
    $user = User::query()->create([
        'name' => 'Profile Details',
        'email' => 'details@example.com',
        'phone' => '099-111-1112',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/profile');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.name', 'Profile Details');
});

it('updates a user profile through the profile command pipeline', function () {
    $user = User::query()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
        'phone' => '099-111-1113',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/profile', [
        'name' => 'New Name',
        'email' => 'new@example.com',
        'phone' => '099-222-2222',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Profile updated.')
        ->assertJsonPath('data.name', 'New Name')
        ->assertJsonPath('data.email', 'new@example.com')
        ->assertJsonPath('data.phone', '099-222-2222');

    $user->refresh();

    expect($user->email)->toBe('new@example.com')
        ->and($user->phone)->toBe('099-222-2222');
});

it('returns the shared validation envelope for invalid profile input', function () {
    $user = User::query()->create([
        'name' => 'Valid User',
        'email' => 'valid@example.com',
        'phone' => '099-111-1114',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/profile', [
        'name' => 'Bad',
        'email' => 'not-email',
        'phone' => 'wrong',
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Validation failed.')
        ->assertJsonStructure([
            'errors' => ['name', 'email', 'phone'],
        ]);
});

it('rejects duplicate profile email and phone values', function () {
    User::query()->create([
        'name' => 'Taken User',
        'email' => 'taken@example.com',
        'phone' => '099-333-3333',
        'password' => Hash::make('password123'),
    ]);

    $user = User::query()->create([
        'name' => 'Editable User',
        'email' => 'editable@example.com',
        'phone' => '099-444-4444',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->putJson('/api/profile', [
        'name' => 'Editable User',
        'email' => 'taken@example.com',
        'phone' => '099-333-3333',
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonPath('success', false)
        ->assertJsonStructure([
            'errors' => ['email', 'phone'],
        ]);
});
