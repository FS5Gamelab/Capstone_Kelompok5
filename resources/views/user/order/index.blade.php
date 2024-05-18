<style>
    .card {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>
<div>
    @if (session()->has('message'))
        {{ session('message') }}
    @endif
</div>
<a href="{{ route('dashboard.user') }}"> <- Back to Dashboard </a>
        <h1>Cart</h1>
        @foreach ($orders as $order)
            <div class="card">
                <div>{{ $order->customer->name }}</div>
                <div>{{ $order->product->product_name }}</div>
                <div>{{ $order->product->price }}</div>
                <div>{{ $order->product->type }}</div>
                <div>{{ $order->product->description }}</div>
                <div>{{ $order->product->product_image }}</div>
                <div>{{ $order->product->category->category_name }}</div>
                <form action="/add-to-cart" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                    <input type="submit" name="change" value="-">
                    {{ $order->quantity }}
                    <input type="submit" name="change" value="+">
                </form>
                <div>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</div>
                <div>{{ $order->checked_out }}</div>
            </div>
        @endforeach
        @if (count($orders) == 0)
            <h5>No items in cart</h5>
        @else
            <h5>Total : Rp. {{ number_format($total, 0, ',', '.') }}</h5>
            <form action="/checkout" method="post">
                @csrf
                @foreach ($orders as $order)
                    <input type="hidden" name="ids[]" value="{{ $order->id }}">
                @endforeach
                <input type="hidden" name="cart_total" value="{{ $total }}">
                <input type="submit" name="checkout" value="checkout">
            </form>
        @endif
