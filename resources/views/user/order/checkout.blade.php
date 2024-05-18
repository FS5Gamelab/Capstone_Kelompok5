<style>
    .card {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>
<a href="{{ route('dashboard.user') }}"> <- Back to Dashboard </a>
        <h1>Checkout</h1>
        <div>
            @if (session()->has('success'))
                {{ session('success') }}
            @endif
        </div>
        @if (count($orders) == 0)
            <h5>No items in checkout</h5>
        @endif
        @foreach ($carts as $index => $cart)
            <div class="card">
                <form action="{{ route('cart.delete', ['cartId' => $cart->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Batalkan Checkout</button>
                </form>
                @foreach ($orders[$index] as $order)
                    <li>Order ID: {{ $order->id }}</li>
                    <div>Product Name: {{ $order->product->product_name }}</div>
                    <div>
                        Quantity: {{ $order->quantity }} -
                        Total Price: Rp. {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                @endforeach
                @if ($cart->status != null)
                    <div>Status: {{ $cart->status }}</div>
                @endif
                <div>Total Bayar: Rp. {{ number_format($cart->cart_total, 0, ',', '.') }}</div>
                {{-- <form action="/pay/{{ $cart->id }}" method="post">
                    @csrf
                    <input type="submit" value="Bayar">
                </form> --}}
                <form action="{{ route('pay', ['cartId' => $cart->id]) }}">
                    <button type="submit">Bayar</button>
                </form>

            </div>
        @endforeach
