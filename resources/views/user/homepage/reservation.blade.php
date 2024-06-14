@extends('layouts.app-user', ['title' => 'Reservation'])

@section('main-content')
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
                                        placeholder="Your name">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="name-error"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" class="form-control" name="phone"
                                        placeholder="Phone number">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="phone-error"></span>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="people" class="form-label">People (max:10)</label>
                                    <input type="number" id="people" class="form-control" name="people"
                                        placeholder="Number of people" min="1" max="10">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="people-error"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mandatory">
                                            <p class="form-label">Date</p>
                                            <input type="date" class="form-control mb-3 flatpickr-no-config"
                                                placeholder="Select date.." id="date-choose">
                                            <span class="tw-text-red-500 tw-text-xs mt-1 " id="date-error"></span>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mandatory">
                                            <p class="form-label">Time</p>
                                            <input type="time" class="form-control mb-3 flatpickr-time-picker"
                                                placeholder="Select time.." id="time-choose">
                                            <span class="tw-text-red-500 tw-text-xs mt-1 " id="time-error"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.loader')
    @include('layouts.hide')
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
@section('js')
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

    <script>
        $("#loader").hide();

        $("#reservation-form").submit(function(e) {
            e.preventDefault();
            $("#loader").show();

            $('.tw-text-red-500').text('');
            let formData = {
                name: $('#name').val(),
                phone: $('#phone').val(),
                people: parseInt($('#people').val()),
                date: $('#date-choose').val(),
                time: $('#time-choose').val(),
                _token: '{{ csrf_token() }}'
            }
            //ajax
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
                        //empty
                        $('#reservation-form')[0].reset();
                    } else if (response.success == false) {
                        Swal.fire({
                            icon: 'error',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        let errors = response.errors;
                        $('#name-error').text(errors.name ? errors.name[0] : '');
                        $('#phone-error').text(errors.phone ? errors.phone[0] : '');
                        $('#people-error').text(errors.people ? errors.people[0] : '');
                        $('#date-error').text(errors.date ? errors
                            .date[0] : '');
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
@endsection
