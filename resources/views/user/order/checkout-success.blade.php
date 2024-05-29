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
                                                                    <img class="tw-h-24 tw-w-24 tw-max-w-full tw-rounded-lg tw-object-cover"
                                                                        alt=""
                                                                        src="{{ asset('/static/images/samples/1.png') }}" />
                                                                </div>

                                                                <div
                                                                    class="tw-relative tw-flex tw-flex-1 tw-flex-col tw-justify-between">
                                                                    <div
                                                                        class="sm:tw-col-gap-5 sm:tw-grid sm:tw-grid-cols-2">
                                                                        <div class="tw-pr-8 sm:tw-pr-5">
                                                                            <p
                                                                                class="tw-text-base tw-font-semibold tw-text-gray-900 dark:tw-text-white">
                                                                                {{ $cart->product->product_name }}
                                                                            </p>
                                                                            <p
                                                                                class="tw-mx-0 tw-mt-1 tw-mb-0 tw-text-sm tw-text-gray-400">
                                                                                &#64;Rp{{ number_format($cart->product->price, 0, ',', '.') }}
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
                                                                    <a href="javascript:void(0)"
                                                                        data-id="{{ $cart->id }}" id="btn-comment"
                                                                        class="btn btn-primary btn-sm !tw-mr-3 mt-2">
                                                                        Rating and review
                                                                    </a>
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
@endSection
@section('css')
    <style>
        .ps--active-x>.ps__rail-x {
            display: none;
        }
    </style>
@endSection

@section('js')
    <script>
        $('#loader').hide();
        $(document).on('click', '#btn-comment', function() {
            let id = $(this).data('id');
            $("#modal-comment").modal('show');
        })
        // $(document).ready(function() {
        //     $(document).on('click', '#btn-comment', function() {
        //         let id = $(this).data('id');
        //         $('#loader').show();
        //         $.ajax({
        //             url: `/comment/${id}`,
        //             type: 'GET',
        //             success: function(response) {
        //                 $('#loader').hide();

        //                 // Clear previous content
        //                 $('#cart-items').empty();
        //                 $('#note').text('');
        //                 $('#total-price').text('');

        //                 // Insert new content
        //                 response.carts.forEach(cart => {
        //                     $('#cart-items').append(`
    //                 <div class="col-md-6">
    //                     <div class="row">
    //                         <div class="col-md-2 tw-font-bold">
    //                             ${cart.quantity}
    //                         </div>
    //                         <div class="col-md-10">
    //                             ${cart.product.product_name}
    //                         </div>
    //                     </div>
    //                 </div>
    //                 <div class="col-md-6">
    //                     <div class="row">
    //                         <div class="col-md-6 !tw-text-xs">
    //                             &#64;Rp${cart.product.price.toLocaleString('id-ID')}
    //                         </div>
    //                         <div class="col-md-6 tw-font-bold">
    //                             Rp${cart.cart_total.toLocaleString('id-ID')}
    //                         </div>
    //                     </div>
    //                 </div>
    //             `);
        //                 });

        //                 $('#note').text(response.order.note);
        //                 $('#total-price').text(
        //                     `Rp${response.order.total_price.toLocaleString('id-ID')}`);

        //                 $('#modal-order').modal('show');
        //             },
        //             error: function(xhr, status, error) {
        //                 $('#loader').hide();
        //                 console.error('AJAX Error:', error);
        //             }
        //         });
        //     })
        // });
    </script>
@endSection
