@extends('layouts.app-user', ['title' => 'Checkout History'])
@section('main-content')
    <section class="section">
        <div class="row tw-flex tw-justify-center">
            <div class="col-md-5 col-lg-4 mt-2">
                @include('layouts.partials.sidebar-user')
            </div>
            <div class="col-md-7 col-lg-8 mt-2">
                @if ($orders->count() > 0)
                    @foreach ($orders as $index => $order)
                        <div class="card">
                            <div class="card-header mb-2">
                                <h3 class="!tw-text-lg tw-font-semibold">Order #{{ $order->id }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="tw-mx-auto tw-mt-2 tw-max-w-2xl md:tw-mt-2" id="count">
                                    <div class="tw-bg-white dark:tw-bg-gray-800 tw-shadow rounded-3">
                                        <div class="tw-px-4 tw-py-6 sm:tw-px-8 sm:tw-py-10">
                                            <div class="tw-flow-root mb-3">
                                                <ul class="tw--my-8">
                                                    <div id="index_{{ $order->id }}">
                                                        <p>{{ $carts[$index]->count() }} item(s)</p>
                                                        @foreach ($carts[$index] as $cart)
                                                            <li
                                                                class="tw-flex tw-flex-col tw-space-y-3 tw-py-6 tw-text-left lg:tw-flex-row lg:tw-space-x-5 lg:tw-space-y-0">
                                                                <div class="tw-shrink-0">
                                                                    @if ($cart->product)
                                                                        @if ($cart->product->product_image)
                                                                            @if (Str::startsWith($cart->product->product_image, 'uploads/'))
                                                                                <img src="{{ asset('storage/' . $cart->product->product_image) }}"
                                                                                    class="tw-h-24 tw-w-24 tw-max-w-full tw-rounded-lg tw-object-cover"
                                                                                    alt="{{ $cart->product->product_image }}">
                                                                            @else
                                                                                <img src="{{ asset($cart->product->product_image) }}"
                                                                                    class="tw-h-24 tw-w-24 tw-max-w-full tw-rounded-lg tw-object-cover"
                                                                                    alt="{{ $cart->product->product_image }}">
                                                                            @endif
                                                                        @else
                                                                            <img class="tw-h-24 tw-w-24 tw-max-w-full tw-rounded-lg tw-object-cover"
                                                                                alt=""
                                                                                src="{{ asset('/static/images/samples/1.png') }}" />
                                                                        @endif
                                                                    @else
                                                                        Product Deleted
                                                                    @endif

                                                                </div>

                                                                <div
                                                                    class="tw-relative tw-flex tw-flex-1 tw-flex-col tw-justify-between">
                                                                    <div
                                                                        class="sm:tw-col-gap-5 sm:tw-grid sm:tw-grid-cols-2">
                                                                        <div class="tw-pr-8 sm:tw-pr-5">
                                                                            <p
                                                                                class="tw-text-base tw-font-semibold tw-text-gray-900 dark:tw-text-white">
                                                                                {{ $cart->product->product_name ?? 'Product Deleted' }}
                                                                            </p>
                                                                            <p
                                                                                class="tw-mx-0 tw-mt-1 tw-mb-0 tw-text-sm tw-text-gray-400">
                                                                                &#64;Rp{{ number_format($cart->product->price ?? 0, 0, ',', '.') }}
                                                                            </p>
                                                                            <div class="sm:tw-order-1 mt-2">
                                                                                <div
                                                                                    class="tw-mx-auto tw-flex tw-h-8 tw-text-gray-600">

                                                                                    <div
                                                                                        class="tw-flex tw-w-10 tw-items-center tw-justify-center tw-text-xs tw-uppercase tw-transition dark:tw-text-white">
                                                                                        x{{ $cart->quantity }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="tw-mt-4 tw-flex tw-items-end tw-justify-between sm:tw-mt-0 sm:tw-items-start sm:tw-justify-end">
                                                                            <p
                                                                                class="tw-shrink-0 tw-w-20 tw-text-base tw-font-semibold tw-text-gray-900 dark:tw-text-gray-200 sm:tw-order-2 sm:tw-ml-8 sm:tw-text-right tw-text-nowrap tw-mr-4">

                                                                                Rp{{ number_format($cart->cart_total, 0, ',', '.') }}
                                                                            </p>


                                                                        </div>
                                                                    </div>
                                                                    <div id="cart_{{ $cart->id }}">

                                                                        @if ($cart->review == null)
                                                                            <a href="javascript:void(0)"
                                                                                data-id="{{ $cart->product->id }}"
                                                                                id="btn-comment"
                                                                                data-order="{{ $order->id }}"
                                                                                data-cart="{{ $cart->id }}"
                                                                                class="btn btn-primary btn-sm !tw-mr-3 mt-2">
                                                                                Rating and review
                                                                            </a>
                                                                        @else
                                                                            <div
                                                                                class="row tw-mb-3 tw-flex tw-justify-between tw-items-center">
                                                                                <div class="col-8">
                                                                                    @for ($i = 1; $i <= $cart->review->rating; $i++)
                                                                                        <div class="tw-mt-2 tw-inline-flex">
                                                                                            <img src="{{ asset('static/images/review/star-symbol-icon.svg') }}"
                                                                                                alt=""
                                                                                                class="tw-h-5 tw-w-5">
                                                                                        </div>
                                                                                    @endfor
                                                                                    @if ($cart->review->rating < 5)
                                                                                        @for ($i = 1; $i <= 5 - $cart->review->rating; $i++)
                                                                                            <div
                                                                                                class="tw-mt-2 tw-inline-flex">
                                                                                                <img src="{{ asset('static/images/review/star-full-icon.svg') }}"
                                                                                                    alt=""
                                                                                                    class="tw-h-5 tw-w-5">
                                                                                            </div>
                                                                                        @endfor
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-4 text-end">
                                                                                    @if ($cart->product)
                                                                                        <a href="javascript:void(0)"
                                                                                            data-id="{{ $cart->review->id }}"
                                                                                            data-cart="{{ $cart->id }}"
                                                                                            data-order="{{ $order->id }}"
                                                                                            data-product="{{ $cart->product->id }}"
                                                                                            id="btn-edit"
                                                                                            class="!tw-mr-3 mt-2 !tw-text-xs">
                                                                                            Edit
                                                                                        </a>
                                                                                        <a href="javascript:void(0)"
                                                                                            data-id="{{ $cart->review->id }}"
                                                                                            data-cart="{{ $cart->id }}"
                                                                                            data-order="{{ $order->id }}"
                                                                                            data-product="{{ $cart->product->id }}"
                                                                                            id="btn-delete"
                                                                                            class="!tw-mr-3 mt-2 !tw-text-red-500 hover:!tw-text-red-700 !tw-text-xs">
                                                                                            Delete
                                                                                        </a>
                                                                                    @else
                                                                                        <i>Product Deleted</i>
                                                                                    @endif
                                                                                </div>
                                                                            </div>

                                                                            @if ($cart->review->comment)
                                                                                <p class="!tw-text-xs tw-mt-1 tw-text-gray-400"
                                                                                    style="max-width: 300px; word-wrap: break-word;">
                                                                                    {{ $cart->review->comment }}
                                                                                </p>
                                                                            @endif
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </div>
                                                </ul>
                                            </div>
                                            @if ($order->note)
                                                <div class="!tw-mt-16">
                                                    <p class="!tw-text-sm">Note:</p>
                                                    <p class="!tw-text-xs mt-2">
                                                        {{ $order->note }}
                                                    </p>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="tw-mt-3 tw-flex tw-items-center tw-justify-between py-2">
                                    <p class="tw-text-sm tw-font-medium tw-text-gray-400">Total</p>
                                    <p class="tw-text-2xl tw-font-semibold tw-text-gray-900 dark:tw-text-gray-200">
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        <p class="text-center">Nothing to show</p>
                    </div>
                @endif

            </div>
        </div>


    </section>


    @include('layouts.loader')
    @include('layouts.modal.modal-comment')
    @include('layouts.modal.modal-comment-edit')

    <table id="table1"></table>
@endSection
@section('css')
    <style>
        .ps--active-x>.ps__rail-x {
            display: none;
        }

        .dataTable-wrapper {
            display: none;
        }
    </style>
@endSection

@section('js')
    <script>
        $('#loader').hide();
        $(document).on('click', '#btn-delete', function() {
            let id = $(this).data('id');
            let cart = $(this).data('cart');
            let order = $(this).data('order');
            let product = $(this).data('product');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#loader').show();
                    $.ajax({
                        url: `/review/delete/${id}`,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#loader').hide();
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                })
                                $(`#cart_${cart}`).empty();
                                let reviewContent = `
                                <a href="javascript:void(0)"
                                data-id="${product}"
                                id="btn-comment"
                                data-order="${order}"
                                data-cart="${cart}"
                                class="btn btn-primary btn-sm !tw-mr-3 mt-2">
                                Rating and review
                                </a>
                                `
                                $(`#cart_${cart}`).html(reviewContent);

                            }
                        },
                        error: function(response) {
                            $('#loader').hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "Something went wrong!",
                                showConfirmButton: true,
                            })
                        }
                    })
                }
            })

        })
    </script>
@endSection
