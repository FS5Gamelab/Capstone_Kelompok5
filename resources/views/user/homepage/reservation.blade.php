@extends('layouts.app-user', ['title' => 'Reservation'])

@section('main-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Book a table</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" id="reservation-form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Your name" value="{{ Auth::user()->name ?? '' }}"
                                                {{ Auth::user() ? 'readonly' : '' }}>
                                            <span class="tw-text-red-500 tw-text-xs mt-1" id="name-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" id="phone" class="form-control" name="phone"
                                                placeholder="Phone number" value="{{ Auth::user()->phone ?? '' }}"
                                                {{ Auth::user() ? 'readonly' : '' }}>
                                            <span class="tw-text-red-500 tw-text-xs mt-1" id="phone-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="people" class="form-label">People (max:10)</label>
                                            <input type="number" id="people" class="form-control" name="people"
                                                placeholder="Number of people" min="1" max="10">
                                            <span class="tw-text-red-500 tw-text-xs mt-1" id="people-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="table" class="form-label">Table No</label>
                                            <select name="table" id="table" class="form-control form-select">
                                                <option value="" hidden>Select Table</option>
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <span class="tw-text-red-500 tw-text-xs mt-1" id="table-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group mandatory">
                                                    <p class="form-label">Date</p>
                                                    <input type="date" class="form-control mb-3 flatpickr-no-config"
                                                        placeholder="Select date.." id="date-choose">
                                                    <span class="tw-text-red-500 tw-text-xs mt-1" id="date-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mandatory">
                                                    <p class="form-label">Time</p>
                                                    <input type="time" class="form-control mb-3 flatpickr-time-picker"
                                                        placeholder="Select time.." id="time-choose">
                                                    <span class="tw-text-red-500 tw-text-xs mt-1" id="time-error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <h6>Menu Total: Rp <span id="total-price">0</span></h6>
                                    </div>
                                    <div class="col-12">
                                        <h6>DP yang harus dibayar: Rp <span id="dp-price">100.000</span></h6>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">With Menu</h4>
                    <a href="javascript:void(0)" id="btn-menu" class="btn btn-primary btn-sm mb-3">
                        <i class="bi bi-plus-lg"></i>
                        Add Menu
                    </a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="table2">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="tw-text-sm" id="reservation-menu">
                                    <!-- Menu items will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.loader')
    @include('layouts.hide')

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    @foreach ($menus as $menu)
                        <div class="row mb-2">
                            <div class="col-3">
                                @if ($menu->product_image)
                                    @if (Str::startsWith($menu->product_image, 'uploads/'))
                                        <img src="{{ asset('storage/' . $menu->product_image) }}" class="rounded"
                                            style="height: 100px; width: 100px;" alt="{{ $menu->product_image }}">
                                    @else
                                        <img src="{{ asset($menu->product_image) }}" class="rounded"
                                            style="height: 100px; width: 100px;" alt="{{ $menu->product_image }}">
                                    @endif
                                @else
                                    <img class="rounded" style="height: 100px; width: 100px;"
                                        src="{{ asset('/static/images/samples/1.png') }}" alt="Card image cap">
                                @endif
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-10">
                                        <h6>{{ $menu->product_name }}</h6>
                                        <small>Rp. {{ number_format($menu->price, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="col-2">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-add-menu"
                                            data-id="{{ $menu->id }}" data-name="{{ $menu->product_name }}"
                                            data-price="{{ $menu->price }}">
                                            <i class="bi bi-plus-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        $("#loader").hide();
        $("#btn-menu").click(function() {
            $("#tambahModal").modal('show');
        });

        let totalPrice = 0;
        let dpPrice = 100000;
        $("#total-price").text(totalPrice.toLocaleString('id-ID'));
        $("#dp-price").text(dpPrice.toLocaleString('id-ID'));

        function updateTotals() {
            $("#total-price").text(totalPrice.toLocaleString('id-ID'));
            let dp = dpPrice + (totalPrice * 0.1);
            $("#dp-price").text(dp.toLocaleString('id-ID'));
        }

        function updateQty(id, price, qtyChange) {
            let currentQty = parseInt($(`#menu-qty-${id}`).text());
            currentQty += qtyChange;
            if (currentQty < 1) {
                $(`#menu-${id}`).remove();
                totalPrice -= price;
            } else {
                let total = currentQty * price;
                $(`#menu-qty-${id}`).text(currentQty);
                $(`#menu-total-${id}`).text(total.toLocaleString('id-ID'));
                totalPrice += price * qtyChange;
            }
            updateTotals();
        }

        $(document).on("click", ".btn-add-menu", function() {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let price = $(this).data("price");
            let qty = 1;

            if ($(`#menu-${id}`).length > 0) {
                updateQty(id, price, qty);
            } else {
                let total = qty * price;
                $("#reservation-menu").append(`
            <tr id="menu-${id}">
                <td class="text-nowrap">
                    
                    ${name}
                </td>
                <td>${price.toLocaleString('id-ID')}</td>
                <td class="text-nowrap">
                    <button class="btn btn-sm btn-secondary btn-minus" data-id="${id}" data-price="${price}">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                    <span id="menu-qty-${id}" class="mx-2">
                    ${qty}
                    </span>
                    <button class="btn btn-sm btn-secondary btn-plus" data-id="${id}" data-price="${price}">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </td>
                <td id="menu-total-${id}">${total.toLocaleString('id-ID')}</td>
                <td class="text-nowrap">
                    <button class="btn btn-sm btn-danger btn-remove" data-id="${id}" data-price="${price}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `);
                totalPrice += total;
                updateTotals();
            }
        });

        $(document).on("click", ".btn-minus", function() {
            let id = $(this).data("id");
            let price = $(this).data("price");
            updateQty(id, price, -1);
        });

        $(document).on("click", ".btn-plus", function() {
            let id = $(this).data("id");
            let price = $(this).data("price");
            updateQty(id, price, 1);
        });

        $(document).on("click", ".btn-remove", function() {
            let id = $(this).data("id");
            let price = $(this).data("price");
            let qty = parseInt($(`#menu-qty-${id}`).text());
            $(`#menu-${id}`).remove();
            totalPrice -= price * qty;
            updateTotals();
        });

        $("#reservation-form").submit(function(e) {
            e.preventDefault();
            $("#loader").show();

            $('.tw-text-red-500').text('');
            let table = parseInt($('#table').val());
            if (table > 0) {
                table = parseInt($('#table').val());
            } else {
                table = 0;
            }
            let people = parseInt($('#people').val());
            if (people > 0) {
                people = parseInt($('#people').val());
            } else {
                people = 0;
            }
            let formData = {
                name: $('#name').val(),
                phone: $('#phone').val(),
                people: people,
                table: table,
                date: $('#date-choose').val(),
                time: $('#time-choose').val(),
                total_price: parseInt($('#total-price').text().replace(/\./g, '')),
                down_payment: parseInt($('#dp-price').text().replace(/\./g, '')),
                _token: '{{ csrf_token() }}',
                menus: [] // Array untuk menyimpan data menu
            };

            // Ambil data menu dari tabel
            $("#reservation-menu tr").each(function() {
                let menuId = $(this).attr('id').split('menu-')[1];
                let qty = parseInt($(this).find(`#menu-qty-${menuId}`).text());
                let total = parseInt($(this).find(`#menu-total-${menuId}`).text().replace(/\./g, ''));

                formData.menus.push({
                    id: menuId,
                    qty: qty,
                    total: total
                });
            });

            $.ajax({
                url: `/reservation`,
                type: "POST",
                cache: false,
                data: formData,
                success: function(response) {
                    $("#loader").hide();
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "/my-reservations";
                        }, 2000);

                        $('#reservation-form')[0].reset();
                        $("#reservation-menu").empty();
                        totalPrice = 0;
                        dpPrice = 100000;
                        updateTotals();
                    } else if (response.success == false) {
                        Swal.fire({
                            icon: 'error',
                            title: `${response.message}`,
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                }
                            }
                        });
                        let errors = response.errors;
                        console.log(errors);
                        $('#name-error').text(errors.name ? errors.name[0] : '');
                        $('#phone-error').text(errors.phone ? errors.phone[0] : '');
                        $('#people-error').text(errors.people ? errors.people[0] : '');
                        $('#table-error').text(errors.table ? errors.table[0] : '');
                        $('#date-error').text(errors.date ? errors.date[0] : '');
                        $('#time-error').text(errors.time ? errors.time[0] : '');
                    } else if (response.success == "same") {
                        Swal.fire({
                            icon: 'error',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                error: function(error) {
                    $("#loader").hide();
                    console.error('AJAX Error:', error);
                }
            });
        });
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
            minDate: new Date().fp_incr(1),
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
@endsection
