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
        return view('user.dashboard', [
            'products' => Product::all(),
            'cartCount' => $cartCount,
        ]);
    }
    public function homepage()
    {
        return view('user.homepage');
    }
}
