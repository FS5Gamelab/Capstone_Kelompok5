<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

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

    public function forgotIndex()
    {
        return view('auth/forgot');
    }

    public function resetForm(Request $request)
    {
        $user = User::where('remember_token', $request->token)->first();
        if ($user == null) {
            return redirect('/login')->with('error', 'Invalid token');
        } else {
            return view('auth/reset', [
                'token' => $request->token,
                'email' => $user->email
            ]);
        }
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ]);
            } elseif ($user->remember_token != $request->token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token',
                ]);
            } else {
                $user->password = bcrypt($request->password);
                $user->remember_token = Str::random(10);
                $user->save();
                Auth::login($user);
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successfully'
                ]);
            }
        }
    }

    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ]);
            } else {
                Mail::to($request->email)->send(new ResetPassword($user->name, $user->remember_token));
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset link has been sent to your email!'
                ]);
            }
        }
    }

    public function newUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10|max:15',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'remember_token' => Str::random(10),
                "last_login" => now()
            ]);
            Auth::login($user);
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully!',
            ]);
        }
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            User::where('email', $request->email)->update([
                "last_login" => now()
            ]);
            $request->session()->regenerate();
            Auth::logoutOtherDevices($request->password);
            // if (Auth::user()->role == 'admin') {
            //     return to_route('dashboard.admin');
            // } else {
            //     return to_route('dashboard.user');
            // }
            return response()->json([
                'success' => true,
                'message' => 'Login Success!',
                "name" => "Welcome " . Auth::user()->name,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function notice()
    {
        Mail::to(auth()->user()->email)->send(new VerifyEmail(auth()->user()->remember_token, auth()->user()->id, auth()->user()->name));

        return view('auth.verify');
    }

    public function verifyEmail($id, $token)
    {
        $user = User::find($id);
        if ($user->remember_token == $token) {
            $user->email_verified_at = now();
            $user->remember_token = Str::random(10);
            $user->save();
            return redirect('/')->with('success', 'Email verified successfully');
        } else {
            return redirect('/')->with('error', 'Invalid token');
        }
    }
    public function resendVerificationEmail()
    {
        Mail::to(auth()->user()->email)->send(new VerifyEmail(auth()->user()->remember_token, auth()->user()->id, auth()->user()->name));
        return response()->json([
            'success' => true,
            'message' => 'Email verification link has been sent to your email!'
        ]);
    }
}
