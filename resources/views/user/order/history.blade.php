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
                <form action="{{ route('cart.delete', ['cartId' => $cart->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Cart</button>
                </form>
                @foreach ($orders[$index] as $order)
                    <li>Order ID: {{ $order->id }}</li>
                    <div>Product Name: {{ $order->product->product_name }}</div>
                    <div>Quantity: {{ $order->quantity }}</div>
                    <div>Total Price: {{ $order->total_price }}</div>
                    <div>Order Status: {{ $order->order_status }}</div>
                @endforeach
                <div>Total Bayar: {{ $cart->cart_total }}</div>
            </div>
        @endforeach
