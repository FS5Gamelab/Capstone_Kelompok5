<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('user.dashboard', [
            'products' => Product::all()
        ]);
    }
}
