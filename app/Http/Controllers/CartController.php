<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use function Symfony\Component\Clock\now;

class CartController extends Controller
{
    public function index()
    {
        // dd(Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->get());
        return view('user.cart.index', [
            'carts' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->get(),
            'total' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->sum('cart_total'),
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }
    public function addToCart(Request $request)
    {
        $message = 'Product added to cart';
        $quantity = 1;
        $product = Product::find($request->product_id);
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->where('checked_out', 0)->first();
        $cartCount = Cart::where('user_id', auth()->user()->id)->count();
        if ($cart) {
            if ($request->change == "+" || $request->change == "add to cart") {
                $cart->increment('quantity', $quantity);
                $cart->increment('cart_total', $product->price * $quantity);
            } elseif ($request->change == "-") {
                if ($cart->quantity == 1) {
                    $cart->delete();
                    $cartCount = $cartCount - 1;
                    $message = 'Product removed from cart';
                } else {
                    $cart->decrement('quantity', $quantity);
                    $cart->decrement('cart_total', $product->price * $quantity);
                    $cart->updated_at = now();
                }
            }
            $cart->save();
        } else {
            Cart::create([
                "product_id" => $request->product_id,
                "user_id" => auth()->user()->id,
                "cart_total" => $product->price * $quantity
            ]);
            $cartCount = $cartCount + 1;
        }
        return response()->json([
            'success' => true,
            'message' => $message,
            'cartCount' => $cartCount
        ]);
    }
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
        $cartCount = Cart::where('user_id', auth()->user()->id)->count();
        $cart->delete();
        $cartCount = $cartCount - 1;
        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cartCount' => $cartCount
        ]);
    }
}
