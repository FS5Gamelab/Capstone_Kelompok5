@extends('layouts.app-user', ['title' => 'Checkout History'])
@section('main-content')
    <section class="section">
        <div class="row tw-flex tw-justify-center">
            <div class="col-md-5 col-lg-4 mt-2">
                @include('layouts.partials.sidebar-user')
            </div>
            <div class="col-md-7 col-lg-8 mt-2">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Address</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @if ($orders->count() > 0)
                                    @foreach ($orders as $index => $order)
                                        <tr id="index_{{ $order->id }}">
                                            <td>
                                                <ul class="!tw-pl-0">
                                                    @foreach ($carts[$index] as $cart)
                                                        <li class="mb-2 tw-list-none tw-text-nowrap">
                                                            <span
                                                                class="badge bg-info tw-text-white dark:!tw-text-gray-700">
                                                                {{ $cart->quantity }}
                                                            </span>
                                                            <span
                                                                class="badge bg-primary-subtle tw-text-gray-700 dark:tw-text-white">
                                                                @if ($cart->product)
                                                                    {{ $cart->product->product_name }}
                                                                @else
                                                                    Product Deleted
                                                                @endif
                                                            </span>

                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ $order->user->address }}</td>
                                            <td class="tw-text-nowrap">Rp.
                                                {{ number_format($order->total_price, 0, ',', '.') }}
                                            </td>
                                            <td id="status_{{ $order->id }}">
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-warning">{{ $order->status }}</span>
                                                @elseif ($order->status == 'prepare')
                                                    <span class="badge bg-info">{{ $order->status }}</span>
                                                @elseif ($order->status == 'deliver')
                                                    <span class="badge bg-primary">{{ $order->status }}</span>
                                                @elseif ($order->status == 'failed')
                                                    <span class="badge bg-danger">{{ $order->status }}</span>
                                                @elseif ($order->status == 'cancelled')
                                                    <span class="badge bg-danger">{{ $order->status }}</span>
                                                @elseif ($order->status == 'success')
                                                    <span class="badge bg-success">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td class="!tw-text-nowrap">
                                                <a href="javascript:void(0)" data-id="{{ $order->id }}" id="btn-detail"
                                                    class="btn btn-primary btn-sm !tw-mr-3">
                                                    Detail
                                                </a>
                                                @if ($order->status == 'pending')
                                                    <span id="btn-pay">
                                                        <a href="javascript:void(0)" data-id="{{ $order->id }}"
                                                            id="pay-button" class="btn btn-info btn-sm">
                                                            Pay
                                                        </a>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>


    @include('layouts.loader')
    @include('layouts.modal.modal-user')

    <div id="basic" class="!tw-hidden"></div>
    <div id="basic-edit" class="!tw-hidden"></div>
@endSection
@section('css')
    <style>
        .ps--active-x>.ps__rail-x {
            display: none;
        }
    </style>
@endSection

@section('js')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
    <script>
        $('#loader').hide();
        $(document).ready(function() {
            $(document).on('click', '#pay-button', function() {
                let id = $(this).data('id');
                $('#loader').show();
                $.ajax({
                    url: `/pay/${id}`,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#loader').hide();
                        if (response.success) {
                            snap.pay(response.token, {
                                onSuccess: function(result) {
                                    $("#loader").show();
                                    $.ajax({
                                        url: `/success/${id}`,
                                        type: 'POST',
                                        data: {
                                            "_token": "{{ csrf_token() }}"
                                        },
                                        success: function(response) {
                                            $("#loader").hide();
                                            $(`#status_${id}`).html(
                                                `
                                                <span class="badge bg-info">prepare</span>
                                                `
                                            );
                                            $(`#btn-pay a[data-id="${id}"]`)
                                                .hide();
                                            Swal.fire({
                                                icon: 'success',
                                                title: `${response.message}`,
                                                showConfirmButton: false,
                                                timer: 3000
                                            })
                                            window.location.href =
                                                '/checkout/prepare';
                                        },
                                        error: function(xhr, status,
                                            error) {
                                            $('#loader').hide();
                                            console.error('AJAX Error:',
                                                error);
                                        }
                                    })
                                },
                                onClose: function(result) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'You Closed The Payment',
                                        text: "Don't Forget to Complete Your Payment Later",
                                        showConfirmButton: true,
                                    })
                                },
                                onPending: function(result) {},
                                onError: function(result) {
                                    $("#loader").show();
                                    $.ajax({
                                        url: `/failed/${id}`,
                                        type: 'POST',
                                        data: {
                                            "_token": "{{ csrf_token() }}"
                                        },
                                        success: function(response) {
                                            $("#loader").hide();
                                            $(`#status_${id}`).html(
                                                `
                                                <span class="badge bg-danger">failed</span>
                                                `
                                            );
                                            $(`#btn-pay a[data-id="${id}"]`)
                                                .hide();
                                            Swal.fire({
                                                icon: 'error',
                                                title: `${response.message}`,
                                                showConfirmButton: false,
                                                timer: 3000
                                            })
                                            setTimeout(() => {
                                                window.location
                                                    .href =
                                                    '/checkout/failed';
                                            }, 1500)

                                        },
                                        error: function(xhr, status,
                                            error) {
                                            $('#loader').hide();
                                            console.error('AJAX Error:',
                                                error);
                                        }
                                    })
                                },

                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true,
                            })
                        }


                    },
                    error: function(xhr, status, error) {
                        $('#loader').hide();
                        console.error('AJAX Error:', error);
                    }
                });
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btn-detail', function() {
                let id = $(this).data('id');
                $('#loader').show();
                $.ajax({
                    url: `/order/${id}`,
                    type: 'GET',
                    success: function(response) {
                        $('#loader').hide();

                        // Clear previous content
                        $('#cart-items').empty();
                        $('#total-price').text('');
                        // Insert new content
                        response.carts.forEach(cart => {
                            $('#cart-items').append(`
                    <div class="col-6">
                        <div class="row">
                            <div class="col-2 tw-font-bold">
                                ${cart.quantity}
                            </div>
                            <div class="col-10">
                                ${cart.product.product_name}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6 !tw-text-xs text-nowrap">
                                &#64;Rp${cart.product.price.toLocaleString('id-ID')}
                            </div>
                            <div class="col-6 tw-font-bold text-nowrap">
                                Rp${cart.cart_total.toLocaleString('id-ID')}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 tw-border-b my-2">
                       <div class="row tw-flex justify-content-between">
                           <div class="col-3">
                                Note
                           </div>
                           <div class="col-9 text-end">
                                ${cart.note}
                           </div>
                       </div>

                    </div>
                `);
                        });
                        if (response.order.status == 'cancelled') {
                            $("#cancel").show();
                            $("#reason").text(response.order.cancel_reason);
                        }
                        $('#total-price').text(
                            `Rp${response.order.total_price.toLocaleString('id-ID')}`);

                        $('#modal-order').modal('show');
                    },
                    error: function(xhr, status, error) {
                        $('#loader').hide();
                        console.error('AJAX Error:', error);
                    }
                });
            })
        });
    </script>
@endSection
