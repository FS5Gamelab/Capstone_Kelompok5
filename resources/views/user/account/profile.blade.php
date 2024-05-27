@extends('layouts.app-user', ['title' => 'Profile'])

@section('main-content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Account Profile</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <form id="avatar-form" action="/image/update" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center flex-column">
                                    <div class="avatar avatar-2xl">
                                        @if (Auth::user()->profile_image)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Avatar"
                                                class="img-preview">
                                        @else
                                            <img src="{{ asset('/static/images/faces/1.jpg') }}" alt="Avatar"
                                                class="img-preview">
                                        @endif
                                        <div
                                            class="tw-h-max tw-w-max tw-bg-violet-600 tw-rounded-full tw-absolute tw-bottom-0 tw-right-0">
                                            <label for="image"
                                                class="tw-text-center tw-text-white tw-px-2 tw-py-1 tw-cursor-pointer">
                                                <i class="bi bi-camera-fill"></i>
                                            </label>
                                            <input type="file" id="image" name="image" class="tw-hidden"
                                                onchange="previewImage()" accept="image/*" required>
                                        </div>

                                    </div>

                                    <h3 class="mt-3 text-capitalize">{{ Auth::user()->name }}</h3>
                                    <p class="text-small text-capitalize">{{ Auth::user()->role }}</p>
                                </div>
                                <div class="tw-flex tw-items-center tw-justify-end">
                                    <button type="submit" class="btn btn-primary tw-mt-3 d-none" id="btn-save">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form id="profile-form" data-parsley-validate>
                                @csrf
                                <div class="form-group mandatory">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Your Name" value="{{ Auth::user()->name }}">

                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="name-error"></span>

                                </div>
                                <div class="form-group mandatory">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="Your Email" value="{{ Auth::user()->email }}">

                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="email-error"></span>

                                </div>
                                <div class="form-group mandatory">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="Your Phone" value="{{ Auth::user()->phone }}">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="phone-error"></span>

                                </div>
                                <div class="form-group mandatory">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="Your Phone" value="{{ Auth::user()->address }}">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="address-error"></span>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="text-capitalize">Change Password</h3>
                    <div class="card">
                        <div class="card-body">
                            <form id="password-form">
                                @csrf
                                <div class="form-group">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" placeholder="Your Current Password">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="current_password-error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Your New Password">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 " id="password-error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">New Password
                                        Confirmation</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Confirm Your New Password">
                                    <span class="tw-text-red-500 tw-text-xs mt-1 "
                                        id="password_confirmation-error"></span>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layouts.loader')
@endsection
@section('css')
    @vite(['resources/js/pages/parsley.js'])
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
        $("#loader").hide();

        $('#profile-form').on('submit', function(e) {
            e.preventDefault();
            $('.tw-text-red-500').text('');
            name = $("#name").val();
            email = $("#email").val();
            phone = $("#phone").val();
            address = $("#address").val();
            $("#loader").show();
            $.ajax({
                url: "/profile/update",
                type: 'PUT',
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#loader").hide();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        })
                        let errors = response.errors;
                        $('#name-error').text(errors.name ? errors.name[0] : '');
                        $('#phone-error').text(errors.phone ? errors.phone[0] : '');
                        $('#email-error').text(errors.email ? errors.email[0] : '');
                        $('#address-error').text(errors.address ? errors.address[0] : '');
                    }
                },
                error: function(error) {
                    $("#loader").hide();
                    console.log(error);
                }
            })
        });

        $('#password-form').on('submit', function(e) {
            e.preventDefault();
            $('.tw-text-red-500').text('');
            current_password = $("#current_password").val();
            password = $("#password").val();
            password_confirmation = $("#password_confirmation").val();
            $("#loader").show();
            $.ajax({
                url: "/security/update",
                type: 'PUT',
                data: {
                    current_password: current_password,
                    password: password,
                    password_confirmation: password_confirmation,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#loader").hide();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        })
                        $('.tw-text-red-500').text('');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        })
                        let errors = response.errors;
                        if (response.type == 1) {
                            $('#current_password-error').text(errors.current_password ? errors
                                .current_password[0] : '');
                            if (errors.password[0] ==
                                'The password field confirmation does not match.') {
                                $('#password_confirmation-error').text(errors.password ? errors
                                    .password[0] : '');
                            } else {
                                $('#password-error').text(errors.password ? errors.password[0] : '');
                            }
                        } else {
                            $('#current_password-error').text(errors.current_password ? errors
                                .current_password[0] : '');
                        }

                    }
                },
                error: function(error) {
                    $("#loader").hide();
                    console.log(error);
                }
            })
            $('#current_password').val('');
            $('#password').val('');
            $('#password_confirmation').val('');
        });
    </script>

    <script>
        var file;
        var navImg;

        function previewImage() {
            const image = document.querySelector("#image");
            const imgPreview = document.querySelector(".img-preview");
            file = image.files[0];
            const maxSize = 1 * 1024 * 1024;

            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'File size must not exceed 1 MB.',
                    showConfirmButton: true,
                    confirmButtonText: 'Close',
                })
                @if (Auth::user()->profile_image)
                    imgPreview.src = "{{ asset('storage/' . Auth::user()->profile_image) }}";
                @else
                    imgPreview.src = "{{ asset('/static/images/faces/1.jpg') }}";
                @endif
                return;
            }

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#image").change(function() {
                $('#btn-save').removeClass('d-none');
            })
            $("#avatar-form").on("submit", function(e) {
                e.preventDefault();
                $("#loader").show();
                $.ajax({
                    url: "/image/update",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#loader").hide();
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            })
                            $('#image').val('');
                            document.querySelector(".nav-img").src = "storage/" + response
                                .image;
                        } else {
                            console.log(response.errors);
                            $("#loader").hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.errors.image[0],
                            })
                            @if (Auth::user()->profile_image)
                                document.querySelector(".img-preview").src =
                                    "{{ asset('storage/' . Auth::user()->profile_image) }}";
                            @else
                                document.querySelector(".img-preview").src =
                                    "{{ asset('/static/images/faces/1.jpg') }}";
                            @endif
                        }
                    },
                    error: function(error) {
                        $("#loader").hide();
                        console.log(error);
                    }
                })
                $('#btn-save').addClass('d-none');
            })
        })
    </script>
@endsection
