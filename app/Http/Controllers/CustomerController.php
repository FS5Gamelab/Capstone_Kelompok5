<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
        } else {
            $cartCount = 0;
        }
        return view('user.homepage.home', [
            'cartCount' => $cartCount,
        ]);
    }
    public function menu()
    {
        if (auth()->user()) {
            $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
        } else {
            $cartCount = 0;
        }
        return view('user.homepage.menu', [
            'products' => Product::all(),
            'cartCount' => $cartCount,
        ]);
    }
    public function about()
    {
        if (auth()->user()) {
            $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
        } else {
            $cartCount = 0;
        }
        return view('user.homepage.about', [
            'cartCount' => $cartCount,
        ]);
    }
    public function reservation()
    {
        if (auth()->user()) {
            $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
        } else {
            $cartCount = 0;
        }
        return view('user.homepage.reservation', [
            'cartCount' => $cartCount,
        ]);
    }
    public function blog()
    {
        if (auth()->user()) {
            $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
        } else {
            $cartCount = 0;
        }
        return view('user.blog.index', [
            'cartCount' => $cartCount,
        ]);
    }

    public function profile()
    {
        if (auth()->user()->role != "admin") {
            return view('user.account.profile', [
                'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count(),
            ]);
        } else {
            return view('admin.account.profile');
        }
    }

    public function imageUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        // dd($request->image);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        } else {
            $image = $request->file('image');
            if (auth()->user()->profile_image) {
                if ($image) {
                    Storage::disk('public')->delete(auth()->user()->profile_image);
                }
            }
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = now()->format('YmdHis') . '-' . $originalName . '.' . $extension;
            // $image->move(public_path('user/profile-image'), $imageName);
            $profileImage = $image->storeAs('uploads/profile-image', $imageName, 'public');
            User::where('id', auth()->user()->id)->update(['profile_image' => $profileImage]);
            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully',
                'image' => $profileImage
            ]);
        }
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'There is missing data',
            ]);
        } else {
            User::where('id', auth()->user()->id)->update($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
            ]);
        }
    }

    public function securityUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'There is incorrect data',
                'type' => 1,
            ]);
        } elseif (!Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided password does not match your current password.',
                'errors' => ['current_password' => ['The provided password does not match your current password.']],
                'type' => 2,
            ]);
        } else {
            User::where('id', auth()->user()->id)->update(['password' => bcrypt($request->password)]);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully',
            ]);
        }
    }
}
