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
                                    <th>Note</th>
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
                                                                {{ $cart->product->product_name }}
                                                            </span>

                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ $order->user->address }}</td>
                                            <td>{{ $order->note }}</td>
                                            <td class="tw-text-nowrap">Rp.
                                                {{ number_format($order->total_price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-warning">{{ $order->status }}</span>
                                                @elseif ($order->status == 'prepare')
                                                    <span class="badge bg-info">{{ $order->status }}</span>
                                                @elseif ($order->status == 'deliver')
                                                    <span class="badge bg-primary">{{ $order->status }}</span>
                                                @elseif ($order->status == 'failed')
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
                                                    <a href="javascript:void(0)" data-id="{{ $order->id }}"
                                                        id="pay-button" class="btn btn-info btn-sm">
                                                        Pay
                                                    </a>
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
@endSection
@section('css')
    @vite(['resources/scss/pages/simple-datatables.scss', 'resources/js/pages/simple-datatables.js'])

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
                                            $(`#index_${id}`).remove();
                                            Swal.fire({
                                                icon: 'success',
                                                title: `${response.message}`,
                                                showConfirmButton: false,
                                                timer: 3000
                                            })
                                        },
                                        error: function(xhr, status,
                                            error) {
                                            $('#loader').hide();
                                            console.error('AJAX Error:',
                                                error);
                                        }
                                    })
                                },
                                onPending: function(result) {},
                                onError: function(result) {},
                                onClose: function() {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'You Closed The Payment',
                                        text: "Don't Forget to Complete Your Payment Later",
                                        showConfirmButton: true,
                                    })
                                }
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
@endSection

@section('js')
    <script>
        $('#loader').hide();
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
                        $('#note').text('');
                        $('#total-price').text('');

                        // Insert new content
                        response.carts.forEach(cart => {
                            $('#cart-items').append(`
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2 tw-font-bold">
                                ${cart.quantity}
                            </div>
                            <div class="col-md-10">
                                ${cart.product.product_name}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 !tw-text-xs">
                                &#64;Rp${cart.product.price.toLocaleString('id-ID')}
                            </div>
                            <div class="col-md-6 tw-font-bold">
                                Rp${cart.cart_total.toLocaleString('id-ID')}
                            </div>
                        </div>
                    </div>
                `);
                        });

                        $('#note').text(response.order.note);
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
@endsection
