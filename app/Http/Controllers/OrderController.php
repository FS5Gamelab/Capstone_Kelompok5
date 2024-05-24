<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function history()
    {
        if (auth()->user()->role == 'admin') {
            $carts = Cart::where('is_paid', 1)->get();
        } else {
            $carts = Cart::where('customer_id', auth()->user()->customer->id)->where('is_paid', 1)->get();
        }
        $orders = [];
        foreach ($carts as $cart) {
            $orderIds = json_decode($cart->order_id, true);
            $orders[] = Order::whereIn('id', $orderIds)->get();
        }

        // dd($orders);
        // $orders = Order::where('customer_id', auth()->user()->customer->id)->where('cart_id', '!=', null)->where('checked_out', 1)->get();
        return view('user.order.history', [
            'carts' => $carts,
            "orders" => $orders

        ]);
    }
}
