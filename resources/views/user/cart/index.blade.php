@extends('layouts.app-user', ['title' => 'Cart'])

@section('main-content')
    <section class="tw-h-full tw-bg-gray-200 dark:tw-bg-gray-900 tw-py-12 sm:tw-py-16 lg:tw-py-20 mb-4">
        <div class="tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
            <div class="tw-flex tw-items-center tw-justify-center">
                @if ($carts->count() == 0)
                    <h1 class="!tw-text-3xl !tw-font-semibold tw-text-gray-900">Your Cart is Empty</h1>
                @else
                    <h1 class="!tw-text-3xl !tw-font-semibold tw-text-gray-900" id="title">Your Cart</h1>
                @endif

            </div>
            @if ($carts->count() > 0)
                <div class="tw-mx-auto tw-mt-8 tw-max-w-2xl md:tw-mt-12" id="count">
                    <div class="tw-bg-white dark:tw-bg-gray-800 tw-shadow">
                        <div class="tw-px-4 tw-py-6 sm:tw-px-8 sm:tw-py-10">
                            <div class="tw-flow-root">
                                <ul class="tw--my-8">
                                    @foreach ($carts as $cart)
                                        <div id="index{{ $loop->iteration }}">
                                            <input type="hidden" name="product_id" value="{{ $cart->product->id }}"
                                                id="product_id{{ $loop->iteration }}">
                                            <input type="hidden" name="cart_id" value="{{ $cart->id }}"
                                                id="cart_id{{ $loop->iteration }}">
                                            <li
                                                class="tw-flex tw-flex-col tw-space-y-3 tw-py-6 tw-text-left sm:tw-flex-row sm:tw-space-x-5 sm:tw-space-y-0">
                                                <div class="tw-shrink-0">
                                                    <img class="tw-h-24 tw-w-24 tw-max-w-full tw-rounded-lg tw-object-cover"
                                                        alt="" src="{{ asset('/static/images/samples/1.png') }}" />
                                                </div>

                                                <div class="tw-relative tw-flex tw-flex-1 tw-flex-col tw-justify-between">
                                                    <div class="sm:tw-col-gap-5 sm:tw-grid sm:tw-grid-cols-2">
                                                        <div class="tw-pr-8 sm:tw-pr-5">
                                                            <p
                                                                class="tw-text-base tw-font-semibold tw-text-gray-900 dark:tw-text-white">
                                                                {{ $cart->product->product_name }}
                                                            </p>
                                                            <p class="tw-mx-0 tw-mt-1 tw-mb-0 tw-text-sm tw-text-gray-400"
                                                                id="price{{ $loop->iteration }}"
                                                                data-price="{{ $cart->product->price }}">

                                                                &#64; Rp.
                                                                {{ number_format($cart->product->price, 0, ',', '.') }}
                                                            </p>
                                                            <div class="sm:tw-order-1 mt-2">
                                                                <div class="tw-mx-auto tw-flex tw-h-8 tw-text-gray-600">
                                                                    <button
                                                                        class="tw-flex tw-items-center tw-justify-center !tw-rounded-l-md tw-bg-gray-300 tw-px-4 tw-transition hover:tw-bg-gray-500 hover:tw-text-white minus"
                                                                        data-number="{{ $loop->iteration }}">
                                                                        -
                                                                    </button>
                                                                    <div class="tw-flex tw-w-10 tw-items-center tw-justify-center tw-bg-gray-100 dark:tw-bg-gray-700 tw-text-xs tw-uppercase tw-transition dark:tw-text-white"
                                                                        id="quantity{{ $loop->iteration }}">
                                                                        {{ $cart->quantity }}
                                                                    </div>
                                                                    <button
                                                                        class="tw-flex tw-items-center tw-justify-center !tw-rounded-r-md tw-bg-gray-300 tw-px-4 tw-transition hover:tw-bg-gray-500 hover:tw-text-white plus"
                                                                        data-number="{{ $loop->iteration }}">
                                                                        +
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="tw-mt-4 tw-flex tw-items-end tw-justify-between sm:tw-mt-0 sm:tw-items-start sm:tw-justify-end">
                                                            <p class="tw-shrink-0 tw-w-20 tw-text-base tw-font-semibold tw-text-gray-900 dark:tw-text-gray-200 sm:tw-order-2 sm:tw-ml-8 sm:tw-text-right tw-text-nowrap tw-mr-4"
                                                                id="cart_total{{ $loop->iteration }}"
                                                                data-value="{{ $cart->cart_total }}">

                                                                Rp. {{ number_format($cart->cart_total, 0, ',', '.') }}
                                                            </p>


                                                        </div>
                                                    </div>

                                                    <div
                                                        class="tw-absolute tw-top-0 tw-right-0 tw-flex sm:tw-bottom-0 sm:tw-top-auto">
                                                        <button type="button" data-number="{{ $loop->iteration }}"
                                                            id="delete"
                                                            class="tw-flex tw-rounded tw-p-2 tw-text-center tw-text-gray-500 tw-transition-all tw-duration-200 tw-ease-in-out focus:tw-shadow hover:tw-text-red-500">
                                                            <i class="bi bi-trash tw-text-2xl"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                    @endforeach

                                </ul>
                            </div>

                            {{-- <div class="tw-mt-6 tw-border-t tw-border-b tw-py-2">
                        <div class="tw-flex tw-items-center tw-justify-between">
                            <p class="tw-text-sm tw-text-gray-400">Subtotal</p>
                            <p class="tw-text-lg tw-font-semibold tw-text-gray-900 dark:tw-text-gray-200">
                                Rp. {{ number_format($total, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="tw-flex tw-items-center tw-justify-between">
                            <p class="tw-text-sm tw-text-gray-400">Shipping</p>
                            <p class="tw-text-lg tw-font-semibold tw-text-gray-900 dark:tw-text-gray-200">$8.00</p>
                        </div>
                    </div> --}}

                            <div class="form-group tw-mt-6">
                                <label for="note">Note</label>
                                <textarea class="form-control" placeholder="Leave a note here" id="note" name="note"></textarea>
                            </div>
                            <div class="tw-mt-3 tw-flex tw-items-center tw-justify-between tw-border-t tw-border-b py-2">
                                <p class="tw-text-sm tw-font-medium tw-text-gray-400">Total</p>
                                <p class="tw-text-2xl tw-font-semibold tw-text-gray-900 dark:tw-text-gray-200"
                                    id="total" data-value="{{ $total }}">
                                    Rp.
                                    {{ number_format($total, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="tw-mt-6 tw-text-center">
                                <form id="checkout-form" action="/checkout" method="post">
                                    @foreach ($carts as $cart)
                                        <input type="hidden" name="ids[]" value="{{ $cart->id }}">
                                    @endforeach
                                    @csrf

                                    <button type="button"
                                        class="tw-group tw-inline-flex tw-w-full tw-items-center tw-justify-center tw-rounded-md tw-bg-blue-600 tw-px-6 tw-py-4 tw-text-lg tw-font-semibold tw-text-white tw-transition-all tw-duration-200 tw-ease-in-out focus:tw-shadow hover:tw-bg-blue-800"
                                        id="checkout-button">
                                        Checkout
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="tw-group-hover:tw-ml-8 tw-ml-4 tw-h-6 tw-w-6 tw-transition-all"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('layouts.loader')

@endsection
@section('js')
    <script>
        $("#loader").hide();
        $(document).on('click', '#delete', function() {
            var dataNumber = $(this).attr('data-number');
            let cart_id = $("#cart_id" + dataNumber).val();
            let token = $("meta[name='csrf-token']").attr("content");
            let cart_total = parseInt($("#cart_total" + dataNumber).attr('data-value'));
            let total = parseInt($("#total").attr('data-value'));
            Swal.fire({
                title: 'Are you sure to remove this product from cart?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").show();
                    $.ajax({
                        url: `/cart/${cart_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        error: function(error) {
                            $("#loader").hide();
                            console.log(error);
                        },
                        success: function(response) {
                            $("#loader").hide();
                            $("#cartCount").text(response.cartCount);
                            $("#index" + dataNumber).remove();
                            total = total - cart_total;
                            $("#total").attr('data-value', total);
                            $("#total").text("Rp. " + total.toLocaleString(
                                'id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }));
                            if (response.cartCount == 0) {
                                $("#count").remove();
                                $("#title").text("Your Cart is Empty");
                            }
                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                    })
                }
            })
        })
        $(document).ready(function() {
            // Event delegation for minus button
            $(document).on('click', '.minus', function() {
                var dataNumber = $(this).attr('data-number');
                let product_id = $("#product_id" + dataNumber).val();
                let token = $("meta[name='csrf-token']").attr("content");
                let price = parseInt($("#price" + dataNumber).attr('data-price'));
                let quantity = parseInt($("#quantity" + dataNumber).text());
                let cart_total = parseInt($("#cart_total" + dataNumber).attr('data-value'));
                let total = parseInt($("#total").attr('data-value'));
                if (quantity == 1) {
                    Swal.fire({
                        title: 'Are you sure to remove this product from cart?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#loader").show();
                            $.ajax({
                                url: `/add-to-cart`,
                                type: "POST",
                                cache: false,
                                data: {
                                    "change": "-",
                                    "product_id": product_id,
                                    "_token": token
                                },
                                error: function(error) {
                                    $("#loader").hide();
                                    console.log(error);
                                },
                                success: function(response) {
                                    $("#loader").hide();
                                    $("#cartCount").text(response.cartCount);
                                    $("#index" + dataNumber).remove();
                                    total = total - price;
                                    $("#total").attr('data-value', total);
                                    $("#total").text("Rp. " + total.toLocaleString(
                                        'id-ID', {
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }));
                                    if (response.cartCount == 0) {
                                        $("#count").remove();
                                        $("#title").text("Your Cart is Empty");
                                    }
                                    Swal.fire({
                                        icon: 'success',
                                        title: `${response.message}`,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                },
                            })
                        }
                    })
                } else if (quantity > 1) {

                    // $("#loader").show();
                    $.ajax({
                        url: `/add-to-cart`,
                        type: "POST",
                        cache: false,
                        data: {
                            "change": "-",
                            "product_id": product_id,
                            "_token": token
                        },
                        error: function(error) {
                            $("#loader").hide();
                            console.log(error);
                        },
                        success: function(response) {
                            $("#loader").hide();
                            $("#cartCount").text(response.cartCount);
                            quantity = quantity - 1;
                            $("#quantity" + dataNumber).text(quantity);
                            cart_total = price * quantity;
                            $("#cart_total" + dataNumber).attr('data-value', cart_total);
                            $("#cart_total" + dataNumber).text("Rp. " + cart_total
                                .toLocaleString('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }))
                            total = total - price;
                            $("#total").attr('data-value', total);
                            $("#total").text("Rp. " + total.toLocaleString('id-ID', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }));

                        },
                    })
                }
            })
        });

        // Event delegation for plus button
        $(document).on('click', '.plus', function() {
            var dataNumber = $(this).attr('data-number');
            let product_id = $("#product_id" + dataNumber).val();
            let token = $("meta[name='csrf-token']").attr("content");
            let price = parseInt($("#price" + dataNumber).attr('data-price'));
            let quantity = parseInt($("#quantity" + dataNumber).text());
            let cart_total = parseInt($("#cart_total" + dataNumber).attr('data-value'));
            let total = parseInt($("#total").attr('data-value'));
            // $("#loader").show();
            $.ajax({
                url: `/add-to-cart`,
                type: "POST",
                cache: false,
                data: {
                    "change": "+",
                    "product_id": product_id,
                    "_token": token
                },
                error: function(error) {
                    $("#loader").hide();
                    console.log(error);
                },
                success: function(response) {
                    $("#loader").hide();
                    $("#cartCount").text(response.cartCount);
                    quantity = quantity + 1;
                    $("#quantity" + dataNumber).text(quantity);
                    cart_total = price * quantity;
                    $("#cart_total" + dataNumber).attr('data-value', cart_total);
                    $("#cart_total" + dataNumber).text("Rp. " + cart_total
                        .toLocaleString('id-ID', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }))
                    total = total + price;
                    $("#total").attr('data-value', total);
                    $("#total").text("Rp. " + total.toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }));

                },
            })
        });
    </script>

    <script>
        $("#loader").hide();
        $(document).ready(function() {
            $('#checkout-button').on('click', function(e) {
                $("#loader").show();
                e.preventDefault();

                let ids = [];
                let total = parseInt($('#total').attr('data-value'));
                let note = $('#note').val();
                $('#checkout-form input[name="ids[]"]').each(function() {
                    ids.push($(this).val());
                });

                let formData = {
                    "ids": ids,
                    "total": total,
                    "note": note,
                    "_token": '{{ csrf_token() }}'
                };

                $.ajax({
                    url: '/checkout',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $("#loader").hide();
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true
                            })
                        }
                        setTimeout(() => {
                            window.location.href = '/checkout';
                        }, 1000);

                    },
                    error: function(error) {
                        $("#loader").hide();
                        console.log(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong. Please try again later.',
                            showConfirmButton: true
                        });
                    }
                });
            });
        });
    </script>
@endsection
