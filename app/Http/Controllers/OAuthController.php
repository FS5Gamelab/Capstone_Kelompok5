<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        if ($request->has('error')) {
            // Redirect to login with an optional message
            return redirect()->route('login')->with('error', 'Login via Google dibatalkan.');
        }
        $google_user = Socialite::driver('google')->user();
        $registeredUser = User::where('google_id', $google_user->id)->first();
        // dd($registeredUser);

        if (!$registeredUser) {
            $user = User::updateOrCreate([
                'google_id' => $google_user->id,
            ], [
                'email' => $google_user->email,
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ]);

            Customer::create([
                'user_id' => $user->id,
                'name' => $google_user->name,
            ]);

            Auth::login($user);
            if (Auth::user()->role == 'admin') {
                return to_route('dashboard.admin');
            } else {
                return to_route('dashboard.user');
            }
        } else {
            Auth::login($registeredUser);
            if (Auth::user()->role == 'admin') {
                return to_route('dashboard.admin');
            } else {
                return to_route('dashboard.user');
            }
        }
    }
}
