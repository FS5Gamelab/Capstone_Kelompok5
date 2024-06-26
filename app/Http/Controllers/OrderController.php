<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function checkOut(Request $request)
    {
        if (auth()->user()->address == null && auth()->user()->phone == null) {
            return response()->json([
                'success' => false,
                'message' => 'Address and Phone number must be filled',
                'redirect' => '/profile'
            ]);
        }
        $carts = Cart::whereIn('id', $request->ids)->get();
        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock not enough for ' . $cart->product->product_name . ', only ' . $cart->product->stock . ' left',
                    'redirect' => '/cart'
                ]);
                break;
            }
            $product = Product::find($cart->product_id);
            $product->update([
                "stock" => $product->stock - $cart->quantity
            ]);
        }

        $order = Order::create([
            "cart_id" => json_encode($request->ids),
            "user_id" => auth()->user()->id,
            "total_price" => $request->total,
        ]);
        $order = Order::findOrFail($order->id);
        $total_price = $order->total_price;
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
                'order_id' => $order->id,
                'gross_amount' => $total_price,
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $order->update([
            'snap_token' => $snapToken,
            'status' => 'pending',
        ]);

        foreach ($request->ids as $id) {
            $cart = Cart::find($id);
            $cart->update([
                "order_id" => $order->id,
                "checked_out" => 1,

            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Cart checked out',
        ]);

        // return to_route('checkout-index')->with('success', 'Cart checked out');
    }

    public function checkoutIndex()
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('status', '!=', null)->latest()->get();
        foreach ($orders as $order) {
            if ($order->status == 'pending' && $order->created_at < now()->subDays(1)) {
                $order->update([
                    'status' => 'failed',
                ]);
                $cartIds = json_decode($order->cart_id, true);
                $carts = Cart::whereIn('id', $cartIds)->get();
                foreach ($carts as $cart) {
                    $product = Product::find($cart->product_id);
                    $product->update([
                        'stock' => $product->stock + $cart->quantity
                    ]);
                }
            }
        }
        $carts = [];
        foreach ($orders as $order) {
            $cartIds = json_decode($order->cart_id, true);
            $carts[] = Cart::whereIn('id', $cartIds)->get();
        }
        return view('user.order.checkout', [
            "orders" => $orders,
            'carts' => $carts,
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }
    public function checkoutSuccess()
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('status', 'success')->latest()->get();

        $carts = [];
        foreach ($orders as $order) {
            $cartIds = json_decode($order->cart_id, true);
            $carts[] = Cart::whereIn('id', $cartIds)->get();
        }
        return view('user.order.checkout-success', [
            "orders" => $orders,
            'carts' => $carts,
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }
    public function checkoutPending()
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('status', 'pending')->latest()->get();

        $carts = [];
        foreach ($orders as $order) {
            $cartIds = json_decode($order->cart_id, true);
            $carts[] = Cart::whereIn('id', $cartIds)->get();
        }
        return view('user.order.checkout', [
            "orders" => $orders,
            'carts' => $carts,
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }
    public function checkoutPrepare()
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('status', 'prepare')->orWhere('status', 'deliver')->latest()->get();

        $carts = [];
        foreach ($orders as $order) {
            $cartIds = json_decode($order->cart_id, true);
            $carts[] = Cart::whereIn('id', $cartIds)->get();
        }
        return view('user.order.checkout-prepare', [
            "orders" => $orders,
            'carts' => $carts,
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }
    public function checkoutFailed()
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('status', 'failed')->latest()->get();

        $carts = [];
        foreach ($orders as $order) {
            $cartIds = json_decode($order->cart_id, true);
            $carts[] = Cart::whereIn('id', $cartIds)->get();
        }
        return view('user.order.checkout', [
            "orders" => $orders,
            'carts' => $carts,
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }
    public function checkoutCancel()
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('status', 'cancelled')->latest()->get();

        $carts = [];
        foreach ($orders as $order) {
            $cartIds = json_decode($order->cart_id, true);
            $carts[] = Cart::whereIn('id', $cartIds)->get();
        }
        return view('user.order.checkout', [
            "orders" => $orders,
            'carts' => $carts,
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }

    public function detail($id)
    {
        $order = Order::findOrFail($id);
        $cartIds = json_decode($order->cart_id, true);
        $carts = Cart::whereIn('id', $cartIds)->with('product')->get();

        // Map carts to include product data
        $carts = $carts->map(function ($cart) {
            return [
                'id' => $cart->id,
                'quantity' => $cart->quantity,
                'cart_total' => $cart->cart_total,
                'product' => [
                    'product_name' => $cart->product->product_name ?? 'Product Deleted',
                    'price' => $cart->product->price ?? 0,
                ],
                'note' => $cart->note ?? ''
            ];
        });
        return response()->json([
            'success' => true,
            'order' => $order,
            'carts' => $carts
        ]);
    }

    public function pay($id)
    {
        $order = Order::findOrFail($id);
        if ($order->is_paid == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Order already paid'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'token' => $order->snap_token
            ]);
        }
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'is_paid' => 1,
            'status' => 'prepare',
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Payment success',
        ]);
    }
    public function failed($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => 'failed',
        ]);
        $cartIds = json_decode($order->cart_id, true);
        $carts = Cart::whereIn('id', $cartIds)->get();
        foreach ($carts as $cart) {
            $product = Product::find($cart->product_id);
            $product->update([
                'stock' => $product->stock + $cart->quantity
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Payment with order id ' . $id . ' failed',
        ]);
    }


    public function index()
    {
        $orders = Order::where('status', '!=', null)->where('status', '!=', 'pending')->latest()->get();
        foreach ($orders as $order) {
            if ($order->status == 'pending' && $order->created_at < now()->subDays(1)) {
                $order->update([
                    'status' => 'failed',
                ]);
                $cartIds = json_decode($order->cart_id, true);
                $carts = Cart::whereIn('id', $cartIds)->get();
                foreach ($carts as $cart) {
                    $product = Product::find($cart->product_id);
                    $product->update([
                        'stock' => $product->stock + $cart->quantity
                    ]);
                }
            }
        }
        $carts = [];
        foreach ($orders as $order) {
            $cartIds = json_decode($order->cart_id, true);
            $carts[] = Cart::whereIn('id', $cartIds)->get();
        }
        return view('admin.order.index', [
            "orders" => $orders,
            'carts' => $carts,
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            "status" => $request->status,
            "cancel_reason" => $request->cancel_reason
        ]);
        if ($request->status == 'cancelled') {
            $cartIds = json_decode($order->cart_id, true);
            $carts = Cart::whereIn('id', $cartIds)->get();
            foreach ($carts as $cart) {
                $product = Product::find($cart->product_id);
                $product->update([
                    'stock' => $product->stock + $cart->quantity
                ]);
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }
}
