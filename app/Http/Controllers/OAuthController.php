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
        $registeredEmail = User::where('email', $google_user->email)->first();
        // dd($registeredUser);

        if (!$registeredUser) {
            if ($registeredEmail) {
                $user = User::where('email', $google_user->email)->update([
                    "email_verified_at" => now(),
                    "google_id" => $google_user->id,
                    "last_login" => now()
                ]);

                $user = User::where('email', $google_user->email)->first();

                Auth::login($user);
            } else {
                $user = User::create([
                    "email" => $google_user->email,
                    "name" => $google_user->name,
                    "remember_token" => Str::random(10),
                    "email_verified_at" => now(),
                    "google_id" => $google_user->id,
                    "last_login" => now(),
                    'password' => bcrypt(null),
                ]);

                Auth::login($user);
            }

            if (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin') {
                return to_route('dashboard.admin');
            } else {
                return to_route('homepage');
            }
        } else {
            $registeredUser->update([
                "last_login" => now()
            ]);
            Auth::login($registeredUser);
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'super admin') {
                return to_route('dashboard.admin');
            } else {
                return to_route('homepage');
            }
        }
    }
}
