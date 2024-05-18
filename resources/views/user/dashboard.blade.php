login berhasil
{{ auth()->user()->role }}
{{ auth()->user()->customer->name }}

<form action="/logout" method="post">
    @csrf
    <input type="submit" value="logout">
</form>

<style>
    .card {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }

    .end {
        display: flex;
        justify-content: end;
    }

    .order {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 10px;
        background-color: #f0f0f0;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
    }

    .cart {
        margin-bottom: 10px;
        padding: 10px;
        background-color: #f0f0f0;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
    }
</style>
<div>
    @if (session()->has('success'))
        {{ session('success') }}
    @endif
</div>
<div class="end">
    <div class="order">
        <a class="cart" href="{{ route('cart') }}"> Cart </a>
        <a class="cart" href="{{ route('history') }}"> History </a>
        <a class="cart" href="{{ route('checkout-index') }}"> Chekout </a>
    </div>
</div>

@foreach ($products as $product)
    <div class="card">
        <div>{{ $product->product_name }}</div>
        <div>Rp. {{ number_format($product->price, 0, ',', '.') }}</div>
        <div>{{ $product->type }}</div>
        <div>{{ $product->description }}</div>
        <div>{{ $product->product_image }}</div>
        <div>{{ $product->category->category_name }}</div>
        <form action="/add-to-cart/" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="submit" name="change" value="add to cart">
        </form>
    </div>
@endforeach
