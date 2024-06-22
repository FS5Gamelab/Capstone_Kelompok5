@extends('layouts.app-user', ['title' => 'My Reservation'])
@section('main-content')
    <section class="section">
        <div class="row tw-flex tw-justify-center">
            <div class="col-md-7 col-lg-8 mt-2">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>People</th>
                                    <th>Table No</th>
                                    <th>DP</th>
                                    <th>Menu Total</th>
                                    <th>Status</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($reservations as $reservation)
                                    <tr id="index_{{ $reservation->id }}">
                                        <td class="text-nowrap">
                                            {{ Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</td>
                                        <td class="text-nowrap">
                                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
                                        <td class="text-nowrap">{{ $reservation->people }}</td>
                                        <td class="text-nowrap">{{ $reservation->table }}</td>
                                        <td class="text-nowrap">
                                            Rp{{ number_format($reservation->down_payment, 0, ',', '.') }}</td>
                                        <td class="text-nowrap">
                                            Rp{{ number_format($reservation->total_price, 0, ',', '.') }}</td>
                                        <td id="status_{{ $reservation->id }}">
                                            @if ($reservation->status == 'pending')
                                                <span class="badge bg-warning">pending</span>
                                            @elseif ($reservation->status == 'paid')
                                                <span class="badge bg-info">paid</span>
                                            @elseif ($reservation->status == 'completed')
                                                <span class="badge bg-success">completed</span>
                                            @elseif ($reservation->status == 'cancel')
                                                <span class="badge bg-danger">cancel</span>
                                            @elseif ($reservation->status == 'failed')
                                                <span class="badge bg-danger">failed</span>
                                            @endif
                                        </td>

                                        <td class="text-nowrap">
                                            <a href="javascript:void(0)" data-id="{{ $reservation->id }}" id="btn-detail"
                                                class="btn btn-sm btn-primary me-2">
                                                Detail
                                            </a>
                                            @if ($reservation->status == 'pending')
                                                <a href="javascript:void(0)" data-id="{{ $reservation->id }}"
                                                    id="pay-button" class="btn btn-info btn-sm">
                                                    Pay
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.loader')

    <div class="modal fade" id="modal-reservation" tabindex="-1" role="dialog" aria-labelledby="modalReservationLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReservationLabel">Reservation Detail</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body tw-text-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 tw-font-bold" id="qty">
                                            Qty
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 !tw-text-xs">
                                        </div>
                                        <div class="col-md-6 tw-font-bold">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center tw-justify-between" id="details">
                                <!-- Details will be injected here -->
                            </div>
                            <div class="row d-flex align-items-center tw-justify-between !tw-mt-5">
                                <div class="col-4 text-muted">Time</div>
                                <div class="col-8 text-end" id="time"></div>
                            </div>

                            <div class="!tw-mt-5">
                                <div class="row d-flex align-items-center tw-justify-between">
                                    <div class="col-4 text-muted">Table</div>
                                    <div class="col-8 text-end" id="table"></div>
                                </div>
                            </div>

                            <div
                                class="row d-flex align-items-center tw-justify-between mb-2 !tw-mt-10 tw-border-t tw-border-b py-2">
                                <div class="col-4">Menu Total</div>
                                <div class="col-8 text-end !tw-font-bold" id="total-price"></div>
                            </div>
                            <div
                                class="row d-flex align-items-center tw-justify-between mb-2 !tw-mt-10 tw-border-t tw-border-b py-2">
                                <div class="col-4">DP</div>
                                <div class="col-8 text-end !tw-font-bold" id="dp-price"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endSection
@section('js')
    <script>
        $("#loader").hide();
    </script>

    <script>
        $(document).on("click", "#btn-detail", function() {
            let id = $(this).data("id");
            $("#loader").show();
            $.ajax({
                url: `detail-reservation/${id}`,
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    $("#loader").hide();
                    $('#details').empty();
                    $('#time').empty();
                    $('#table').empty();
                    $('#total-price').empty();
                    $('#dp-price').empty();
                    if (response.menus.length > 0) {
                        $("#qty").show();
                        response.menus.forEach((menu) => {
                            $('#details').append(`
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2 tw-font-bold">
                                ${menu.quantity}
                            </div>
                            <div class="col-md-10">
                                ${menu.product.product_name}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 !tw-text-xs">
                                &#64;Rp${menu.product.price.toLocaleString('id-ID')}
                            </div>
                            <div class="col-md-6 tw-font-bold">
                                Rp${menu.total.toLocaleString('id-ID')}
                            </div>
                        </div>
                    </div>
                            `);
                        });

                    } else {
                        $("#qty").hide();

                    }
                    $('#time').text(`${response.reservation.date} ${response.reservation.time}`);
                    $('#table').text(
                        `Table ${response.reservation.table} for ${response.reservation.people} people`
                    );
                    $('#total-price').text(
                        `Rp${response.reservation.total_price.toLocaleString('id-ID')}`);
                    $('#dp-price').text(
                        `Rp${response.reservation.down_payment.toLocaleString('id-ID')}`);
                    $("#modal-reservation").modal("show");
                },
            });
        })
    </script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#pay-button', function() {
                let id = $(this).data('id');
                $('#loader').show();
                $.ajax({
                    url: `/pay-reservation/${id}`,
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
                                        url: `/success-reservation/${id}`,
                                        type: 'POST',
                                        data: {
                                            "_token": "{{ csrf_token() }}"
                                        },
                                        success: function(response) {
                                            $("#loader").hide();
                                            $(`#status_${id}`).html(
                                                `
                                                <span class="badge bg-info">paid</span>
                                                `
                                            );
                                            $('#pay-button').hide();
                                            Swal.fire({
                                                icon: 'success',
                                                title: `${response.message}`,
                                                showConfirmButton: true,
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
                                        url: `/failed-reservation/${id}`,
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
                                            $('#pay-button').hide();
                                            Swal.fire({
                                                icon: 'error',
                                                title: `${response.message}`,
                                                showConfirmButton: true,

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
@endsection
