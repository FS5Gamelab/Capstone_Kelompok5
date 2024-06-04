@extends('layouts.app', ['title' => 'Orders'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">Orders</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Orders
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="page-content">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="dataTable-top">
                            <div class="dataTable-dropdown">
                                <label for="filterSelect" class="me-3">Status</label>
                                <select id="filterSelect" class="form-select dataTable-selector">
                                    <option value="">All</option>
                                    <option value="prepare">Pending</option>
                                    <option value="deliver">Deliver</option>
                                    <option value="failed">Failed</option>
                                    <option value="cancelled">Cancel</option>
                                </select>
                            </div>
                        </div> --}}
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Name</th>
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
                                            <td>{{ $order->user->name }}</td>

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
                                                                {{ $cart->product->product_name ?? 'Product Deleted' }}
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
                                            <td id="status_{{ $order->id }}">
                                                @if ($order->status == 'prepare' || $order->status == 'deliver')
                                                    <select name="status" id="status"
                                                        class="form-select text-capitalize" data-id="{{ $order->id }}">
                                                        <option value="prepare"
                                                            {{ $order->status == 'prepare' ? 'selected' : '' }}>Prepare
                                                        </option>
                                                        <option value="deliver"
                                                            {{ $order->status == 'deliver' ? 'selected' : '' }}>Deliver
                                                        </option>
                                                        <option value="success">Success
                                                        </option>
                                                    </select>
                                                @elseif ($order->status == 'failed' || $order->status == 'cancelled')
                                                    <span class="badge bg-danger">
                                                        {{ $order->status }}
                                                    </span>
                                                @elseif ($order->status == 'success')
                                                    <span class="badge bg-success">
                                                        {{ $order->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="!tw-text-nowrap" id="action_{{ $order->id }}">
                                                <a href="javascript:void(0)" data-id="{{ $order->id }}" id="btn-detail"
                                                    class="btn btn-primary btn-sm !tw-mr-3">
                                                    Detail
                                                </a>
                                                @if ($order->status == 'prepare' || $order->status == 'deliver')
                                                    <a href="javascript:void(0)" data-id="{{ $order->id }}"
                                                        id="btn-cancel" class="btn btn-danger btn-sm !tw-mr-3">
                                                        Cancel
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
        </section>
    </div>

    @include('layouts.loader')
    @include('layouts.modal.modal-user')
@endsection
@section('css')
    @vite(['resources/scss/pages/simple-datatables.scss', 'resources/js/pages/simple-datatables.js'])
@endsection
@section('js')
    <script>
        $("#loader").hide();
        $(document).on('change', '#status', function(e) {
            e.preventDefault();

            $("#loader").show();
            let id = $(this).data('id');
            let status = $(this).val();
            $.ajax({
                url: `orders/${id}/update`,
                type: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "Order status updated.",
                    });
                    $("#loader").hide();

                    if (status == 'success') {
                        $("#status_" + id).html(
                            `
                            <span class="badge bg-success">success</span>
                            `
                        )
                        $("#action_" + id).html(
                            `
                                <a href="javascript:void(0)" data-id="${id}" id="btn-detail"
                                                    class="btn btn-primary btn-sm !tw-mr-3">
                                                    Detail
                                </a>
                                `
                        );

                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status.',
                    });
                }
            });
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
                        if (response.order.status == 'cancelled') {
                            $("#cancel").show();
                            $("#reason").text(response.order.cancel_reason);
                        }
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

    <script>
        $(document).on('click', '#btn-cancel', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Cancel Reason",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Submit",
                showLoaderOnConfirm: true,
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage("You need to provide a reason for cancellation");
                    } else {
                        return reason;
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").show();
                    let reason = result.value;
                    $.ajax({
                        url: `orders/${id}/update`,
                        type: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}",
                            cancel_reason: reason,
                            status: 'cancelled'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: "Order canceled.",
                            });

                            $("#loader").hide();

                            $("#status_" + id).html(
                                `
                            <span class="badge bg-danger">cancelled</span>
                            `
                            )
                            $("#action_" + id).html(
                                `
                                <a href="javascript:void(0)" data-id="${id}" id="btn-detail"
                                                    class="btn btn-primary btn-sm !tw-mr-3">
                                                    Detail
                                </a>
                                `
                            );
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to cancel order.',
                            });
                        }
                    });
                }
            });
        })
    </script>
@endsection
