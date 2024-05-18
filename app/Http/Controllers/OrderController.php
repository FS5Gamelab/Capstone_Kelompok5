<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('user.order.index', [
            'orders' => Order::where('customer_id', auth()->user()->customer->id)->where('checked_out', 0)->get(),
            'total' => Order::where('customer_id', auth()->user()->customer->id)->where('checked_out', 0)->sum('total_price'),
        ]);
    }

    public function history()
    {
        $carts = Cart::where('customer_id', auth()->user()->customer->id)->where('is_paid', 1)->get();
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
    public function addToCart(Request $request)
    {
        $quantity = 1;
        $product = Product::find($request->product_id);
        $order = Order::where('customer_id', auth()->user()->customer->id)->where('product_id', $request->product_id)->where('checked_out', 0)->first();
        if ($order) {
            if ($request->change == "+" || $request->change == "add to cart") {
                $order->increment('quantity', $quantity);
                $order->increment('total_price', $product->price * $quantity);
            } elseif ($request->change == "-") {
                if ($order->quantity == 1) {
                    $order->delete();
                    return redirect()->back()->with('message', 'Product removed from cart');
                } else {
                    $order->decrement('quantity', $quantity);
                    $order->decrement('total_price', $product->price * $quantity);
                }
            }
            $order->save();
        } else {
            Order::create([
                "product_id" => $request->product_id,
                "customer_id" => auth()->user()->customer->id,
                "total_price" => $product->price * $quantity
            ]);
        }
        return redirect()->back()->with('success', 'Product added to cart');
    }
}
