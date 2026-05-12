<?php

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('registers a user through the auth command pipeline', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John Smith',
        'email' => 'john@example.com',
        'phone' => '099-123-4567',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Registered.')
        ->assertJsonPath('data.user.email', 'john@example.com')
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['user', 'token'],
            'errors',
            'meta',
        ]);

    expect(User::query()->where('email', 'john@example.com')->exists())->toBeTrue();
});

it('logs a user in through the auth command pipeline', function () {
    User::query()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'phone' => '099-123-4568',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'jane@example.com',
        'password' => 'password123',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Authenticated.')
        ->assertJsonPath('data.user.email', 'jane@example.com')
        ->assertJsonStructure([
            'data' => ['user', 'token'],
        ]);
});

it('returns the shared api validation envelope for invalid register input', function () {
    $response = $this->postJson('/api/register', [
        'email' => 'not-an-email',
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Validation failed.')
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors' => ['name', 'phone', 'email', 'password'],
            'meta',
        ]);
});

it('returns the shared api error envelope for invalid credentials', function () {
    User::query()->create([
        'name' => 'Mark Smith',
        'email' => 'mark@example.com',
        'phone' => '099-123-4569',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'mark@example.com',
        'password' => 'wrong-password',
    ]);

    $response
        ->assertUnprocessable()
        ->assertJsonPath('success', false)
        ->assertJsonPath('errors.email.0', 'The provided credentials are incorrect.');
});

it('logs out the current user', function () {
    $user = User::query()->create([
        'name' => 'Kate Smith',
        'email' => 'kate@example.com',
        'phone' => '099-123-4570',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/logout');

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'Logged out.');
});

it('sends a password reset email without leaking account existence', function () {
    Mail::fake();

    $user = User::query()->create([
        'name' => 'Reset Smith',
        'email' => 'reset@example.com',
        'phone' => '099-123-4571',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/password/email', [
        'email' => 'reset@example.com',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('message', 'If the account exists, a reset email has been sent.');

    Mail::assertSent(ResetPasswordEmail::class, fn (ResetPasswordEmail $mail): bool => $mail->user->is($user));
});
