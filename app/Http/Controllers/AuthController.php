<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }
    public function register()
    {
        return view('auth/register');
    }

    public function newUser(Request $request): RedirectResponse
    {
        $validatedUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'min:10', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validatedUser['password'] = bcrypt($validatedUser['password']);
        $user = User::create([
            'email' => $validatedUser['email'],
            'password' => $validatedUser['password'],
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ]);
        Customer::create([
            'user_id' => $user->id,
            'name' => $validatedUser['name'],
            'no_hp' => $validatedUser['no_hp'],
        ]);
        Auth::login($user);
        if (Auth::user()->role == 'admin') {
            return to_route('dashboard.admin');
        } else {
            return to_route('dashboard.user');
        }
    }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Auth::logoutOtherDevices($request->password);
            if (Auth::user()->role == 'admin') {
                return to_route('dashboard.admin');
            } else {
                return to_route('dashboard.user');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login');
    }
}
