<style>
    .card {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>
<a href="{{ route('dashboard.user') }}"> <- Back to Dashboard </a>
        <h1>History</h1>
        @if (count($orders) == 0)
            <h5>No items in history</h5>
        @endif
        @foreach ($carts as $index => $cart)
            <div class="card">

                @foreach ($orders[$index] as $order)
                    <li>Order ID: {{ $order->id }}</li>
                    <div>Product Name: {{ $order->product->product_name }}</div>
                    <div>Quantity: {{ $order->quantity }}</div>
                    <div>Total Price: Rp. {{ number_format($order->total_price, 0, ',', '.') }}</div>
                @endforeach
                @if ($cart->status != null)
                    <div>Status: {{ $cart->status }}</div>
                @endif
                <div>Total Bayar: Rp. {{ number_format($cart->cart_total, 0, ',', '.') }}</div>
            </div>
        @endforeach
