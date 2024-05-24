<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            $cartCount = Cart::where('user_id', auth()->user()->id)->count();
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
            $cartCount = Cart::where('user_id', auth()->user()->id)->count();
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
            $cartCount = Cart::where('user_id', auth()->user()->id)->count();
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
            $cartCount = Cart::where('user_id', auth()->user()->id)->count();
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
            $cartCount = Cart::where('user_id', auth()->user()->id)->count();
        } else {
            $cartCount = 0;
        }
        return view('user.blog.index', [
            'cartCount' => $cartCount,
        ]);
    }
}
