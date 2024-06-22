@extends('layouts.app', ['title' => 'Reservation'])
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="!tw-text-3xl tw-font-semibold">Reservation</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="/admin-dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Reservation
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
                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>People</th>
                                    <th>Table No.</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>DP</th>
                                    <th>Menu Total</th>
                                    <th>Status</th>
                                    <th data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tw-text-sm">
                                @foreach ($reservations as $reservation)
                                    <tr id="index_{{ $reservation->id }}">
                                        <td class="text-nowrap">{{ $reservation->name }}</td>
                                        <td class="text-nowrap">{{ $reservation->phone }}</td>
                                        <td class="text-nowrap">{{ $reservation->people }}</td>
                                        <td class="text-nowrap">{{ $reservation->table }}</td>
                                        <td class="text-nowrap">
                                            {{ Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</td>
                                        <td class="text-nowrap">
                                            {{ Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
                                        <td class="text-nowrap">{{ number_format($reservation->down_payment, 0, ',', '.') }}
                                        </td>
                                        <td class="text-nowrap">{{ number_format($reservation->total_price, 0, ',', '.') }}
                                        </td>
                                        <td>
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
                                                class="btn btn-sm btn-info me-2">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-id="{{ $reservation->id }}" id="btn-edit"
                                                class="btn btn-sm btn-primary me-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-id="{{ $reservation->id }}" id="btn-delete"
                                                class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layouts.loader')
    @include('layouts.modal.modal-reservation')
    <div id="basic" class="!tw-hidden"></div>
    <div id="basic-edit" class="!tw-hidden"></div>

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
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
@section('js')
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

                        $('#details').append(`
                        <h6>No Menu</h6>`);

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

    <script>
        function validateInput(event) {
            const input = event.target;
            const value = input.value;

            input.value = value.replace(/[^0-9]/g, '');

            if (!value.startsWith("08")) {
                input.value = "08";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const noHpInput = document.getElementById("phone");
            noHpInput.addEventListener("input", validateInput);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const peopleInput = document.getElementById('people');

            peopleInput.addEventListener('input', function(event) {
                let value = this.value;

                // Pastikan hanya angka yang diizinkan
                value = value.replace(/[^0-9]/g, '');

                // Jika nilai lebih dari 10, setel menjadi 10
                if (value > 10) {
                    value = 10;
                }

                // Setel nilai input dengan nilai yang divalidasi
                this.value = value;
            });
        });
    </script>
    <script>
        flatpickr(".flatpickr-no-config", {
            dateFormat: "d-M-Y",
            minDate: new Date().fp_incr(0),
            maxDate: new Date().fp_incr(30),
            disableMobile: "true"

        });
        flatpickr(".flatpickr-time-picker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minTime: "09:00",
            maxTime: "21:00",
            disableMobile: "true"
        })
    </script>

    <script>
        $("#loader").hide();
        $(document).on("click", "#btn-edit", function() {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
            $("#loader").show();
            $.ajax({
                url: `reservations/${id}/edit`,
                type: "GET",
                success: function(response) {
                    $("#loader").hide();
                    $("#id").val(response.reservation.id);
                    $("#name").val(response.reservation.name);
                    $("#phone").val(response.reservation.phone);
                    $("#people").val(response.reservation.people);
                    $("#table").val(response.reservation.table);
                    $("#status").val(response.reservation.status);
                    $("#date-choose").val(response.reservation.date);
                    $("#time-choose").val(response.reservation.time);
                    $("#ubahModal").modal("show");
                },
                error: function(xhr, status, error) {
                    $("#loader").hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to get reservation.',
                        showConfirmButton: true,
                    });
                }
            });
        });
    </script>

    <script>
        $(document).on("click", "#btn-update", function() {
            let id = $("#id").val();
            let name = $("#name").val();
            let phone = $("#phone").val();
            let people = $("#people").val();
            let table = $("#table").val();
            let status = $("#status").val();
            let date = $("#date-choose").val();
            let time = $("#time-choose").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $("#ubahModal").modal("hide");
            $("#loader").show();
            $.ajax({
                url: `reservations/${id}/update`,
                type: "PUT",
                data: {
                    name: name,
                    phone: phone,
                    people: people,
                    table: table,
                    status: status,
                    date: date,
                    time: time,
                    _token: token
                },
                success: function(response) {
                    $("#loader").hide();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        })
                        let status;
                        if (response.reservation.status == "cancel") {
                            status = `<span class="badge bg-danger">cancel</span>`;
                        } else if (response.reservation.status == "pending") {
                            status = `<span class="badge bg-warning">pending</span>`;
                        } else if (response.reservation.status == "paid") {
                            status = `<span class="badge bg-info">paid</span>`;
                        } else if (response.reservation.status == "completed") {
                            status = `<span class="badge bg-success">completed</span>`;
                        } else if (response.reservation.status == "failed") {
                            status = `<span class="badge bg-danger">failed</span>`;
                        }
                        $("#index_" + id).html(`
                    <td>${response.reservation.name}</td>
                    <td>${response.reservation.phone}</td>
                    <td>${response.reservation.people}</td>
                    <td>${response.reservation.table}</td>
                    <td>${response.reservation.date}</td>
                    <td>${response.reservation.time}</td>
                    <td>${response.reservation.down_payment}</td>
                    <td>${response.reservation.total_price}</td>
                    <td>${status}</td>
                    <td>
                        <a href="javascript:void(0)" data-id="${response.reservation.id}" id="btn-detail"
                                                class="btn btn-sm btn-info me-2">
                                                <i class="bi bi-eye"></i>
                                            </a>
                        <a href="javascript:void(0)" data-id="${response.reservation.id}" id="btn-edit"
                                            class="btn btn-sm btn-primary me-2">
                                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-id="${response.reservation.id}" id="btn-delete">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                    `);
                    } else {
                        let errors = response.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errorMessages += `${errors[field]}<br>`;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessages,
                            showConfirmButton: true,
                        });
                    }
                },
                error: function(error) {
                    $("#loader").hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update reservation.',
                        showConfirmButton: true,
                    });
                }
            });
        });
    </script>

    <script>
        $(document).on("click", "#btn-delete", function() {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");
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
                    $("#loader").show();
                    $.ajax({
                        url: `reservations/${id}/delete`,
                        type: "DELETE",
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            $("#loader").hide();
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                })
                                $("#index_" + id).remove();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                    showConfirmButton: true
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection
