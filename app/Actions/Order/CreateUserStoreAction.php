<?php

namespace App\Actions\Order;

use App\Actions\GetAnonymousUserId;
use App\Http\Requests\CreateUserRequest;
use App\Models\Product;
use App\Models\User;
use App\Notifications\UserPasswordNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

class CreateUserStoreAction
{
    protected GetAnonymousUserId $getAnonymousUserId;

    public function __construct(GetAnonymousUserId $getAnonymousUserId)
    {
        $this->getAnonymousUserId = $getAnonymousUserId;
    }
    public function createUserStoreAction(Request $request, $token): SymphonyResponse|InertiaResponse|RedirectResponse
    {
        $user_id = auth()->check() ? auth()->id() : $this->getAnonymousUserId->getAnonymousUserId();
        $cartItem = session('cart_' . $user_id, []);

        if (auth()->check()) {
            $request->validate([
                'name' => 'required|string|max:255|min:2',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
            ]);
            $user = auth()->user();
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
            // Note: We don't update email to prevent accidental login issues during checkout
            session(['checkout_user' => $user]);
            return Inertia::location(route('order.addAddress', ['token' => $token]));
        }

        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // User exists but not logged in. We can't log them in securely without a password.
            // But we can store their contact info in session for the order.
            // We will attach the order to this user later.
            session(['checkout_user' => [
                'id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]]);
        } else {
            // Create a new background user with a random password
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt(\Illuminate\Support\Str::random(16)),
            ]);
            
            // Log them in since we just created it
            Auth::login($user);
            session(['cart_' . $user->id => $cartItem]);
            
            session(['checkout_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]]);
        }

        return Inertia::location(route('order.addAddress', ['token' => $token]));
    }
}
