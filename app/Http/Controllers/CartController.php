<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function checkOut(Request $request)
    {
        $cartOrder = Cart::create([
            "order_id" => json_encode($request->ids),
            "customer_id" => auth()->user()->customer->id,
            "cart_total" => $request->cart_total,
        ]);
        foreach ($request->ids as $id) {
            $order = Order::find($id);
            $order->update([
                "cart_id" => $cartOrder->id,
                "checked_out" => 1,
            ]);
        }
        return to_route('dashboard.user')->with('success', 'Order checked out');
    }

    public function delete($cartId)
    {
        $cart = Cart::findOrFail($cartId);

        // Perbarui status checked_out dari semua order yang terkait dengan keranjang
        $orders = Order::where('cart_id', $cart->id)->get();
        foreach ($orders as $order) {
            $order->update([
                'checked_out' => 0,
            ]);
        }

        // Hapus keranjang berdasarkan ID
        $cart->delete();

        return redirect()->route('cart')->with('success', 'Cart deleted');
    }
}
