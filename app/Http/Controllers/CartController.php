<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

use function Symfony\Component\Clock\now;

class CartController extends Controller
{
    public function index()
    {
        return view('user.cart.index', [
            'carts' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->get(),
            'total' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->sum('cart_total'),
            'cartCount' => Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count()
        ]);
    }
    public function addToCart(Request $request)
    {
        if (auth()->user()->email_verified_at == null) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email first',
            ]);
        }
        $message = 'Product added to cart';
        $quantity = 1;
        $product = Product::find($request->product_id);
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->where('checked_out', 0)->first();
        $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
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

    public function delete($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cartCount = Cart::where('user_id', auth()->user()->id)->where('checked_out', 0)->count();
        $cart->delete();
        $cartCount = $cartCount - 1;
        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cartCount' => $cartCount
        ]);
    }
}
