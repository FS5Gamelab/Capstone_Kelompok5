<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CartController extends Controller
{
    public function checkoutIndex()
    {
        $carts = Cart::where('customer_id', auth()->user()->customer->id)->where('is_paid', 0)->get();
        $orders = [];
        foreach ($carts as $cart) {
            $orderIds = json_decode($cart->order_id, true);
            $orders[] = Order::whereIn('id', $orderIds)->get();
        }

        // dd($orders);
        // $orders = Order::where('customer_id', auth()->user()->customer->id)->where('cart_id', '!=', null)->where('checked_out', 1)->get();
        return view('user.order.checkout', [
            'carts' => $carts,
            "orders" => $orders

        ]);
    }
    public function checkOut(Request $request)
    {
        $cartOrder = Cart::create([
            "order_id" => json_encode($request->ids),
            "customer_id" => auth()->user()->customer->id,
            "cart_total" => $request->cart_total,
        ]);
        $cart = Cart::findOrFail($cartOrder->id);
        $cart_total = $cart->cart_total;
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => $cart->id,
                'gross_amount' => $cart_total,
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $cart->update([
            'snap_token' => $snapToken,
            'status' => 'Menunggu Pembayaran',
        ]);

        foreach ($request->ids as $id) {
            $order = Order::find($id);
            $order->update([
                "cart_id" => $cartOrder->id,
                "checked_out" => 1,

            ]);
        }

        return to_route('checkout-index')->with('success', 'Order checked out');
    }

    public function pay($id)
    {
        $cart = Cart::findOrFail($id);
        if ($cart->is_paid == 1) {
            return redirect()->route('history');
        } else {
            return view('user.order.pay', ['cart' => $cart]);
        }
    }

    public function success(Cart $cart)
    {

        $cart->update([
            'is_paid' => 1,
            'status' => 'Pembayaran Berhasil',
        ]);
        return redirect()->route('history')->with('success', 'Pembayaran Berhasil');
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
