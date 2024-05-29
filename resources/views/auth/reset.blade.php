<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reset Password</title>
        @vite(['resources/scss/app.scss', 'resources/scss/themes/dark/app-dark.scss', 'resources/js/initTheme.js', 'resources/js/app.js', 'resources/js/components/dark.js', 'resources/css/app.css', 'resources/js/pages/parsley.js'])
        <link rel="shortcut icon" href="{{ asset('/static/images/logo/favicon.svg') }}" type="image/x-icon">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <div class="theme-toggle d-flex gap-2 align-items-center mt-4 me-4 justify-content-end">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path
                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                        opacity=".3"></path>
                    <g transform="translate(-210 -1)">
                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                        <circle cx="220.5" cy="11.5" r="4"></circle>
                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                    </g>
                </g>
            </svg>
            <div class="form-check form-switch fs-6">
                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                <label class="form-check-label"></label>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                role="img" class="iconify iconify--mdi" width="20" height="20"
                preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                </path>
            </svg>
        </div>
        <form id="reset-form" class="form" data-parsley-validate>
            @csrf
            @method('PUT')
            <div class=" py-3 sm:tw-max-w-xl sm:tw-mx-auto tw-w-full">
                <div
                    class=" px-4 py-10 dark:tw-bg-gray-800 tw-bg-gray-50 tw-mx-8 md:tw-mx-0 tw-shadow tw-rounded-3xl sm:tw-p-10">
                    <div class="tw-flex tw-justify-start">
                        <a href="/">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                    <div class="tw-max-w-md tw-mx-auto tw-text-white">
                        <div class="tw-flex tw-items-center tw-space-x-5 tw-justify-center">
                            <img src="{{ asset('/static/images/logo/logo.svg') }}" alt="" class="img-fluid">
                        </div>
                        <div class="tw-mt-5">
                            <div class="form-group mandatory mb-3">
                                <label for="email"
                                    class="tw-font-semibold tw-text-sm tw-text-gray-400 tw-pb-1 tw-block form-label">E-mail</label>
                                <input id="email" type="email" name="email"
                                    class="tw-border tw-rounded-lg tw-px-3 py-2 mt-1 tw-text-sm tw-w-full dark:tw-bg-gray-700 tw-text-black dark:tw-text-white focus:tw-border-blue-500 focus:tw-ring-4 focus:tw-ring-blue-500"
                                    value="{{ $email }}" readonly />

                                <span class="tw-text-red-500 tw-text-xs mt-1 " id="email-error"></span>

                            </div>
                            <div class="form-group mandatory mb-3">

                                <label for="password"
                                    class="tw-font-semibold tw-text-sm tw-text-gray-400 pb-1 tw-block form-label">Password</label>
                                <input id="password" type="password" name="password"
                                    class="tw-border tw-rounded-lg tw-px-3 py-2 mt-1 tw-text-sm tw-w-full dark:tw-bg-gray-700 tw-text-black dark:tw-text-white focus:tw-border-blue-500 focus:tw-ring-4 focus:tw-ring-blue-500" />

                                <span class="tw-text-red-500 tw-text-xs mt-1 " id="password-error"></span>

                            </div>
                            <div class="form-group mandatory">

                                <label for="password_confirmation"
                                    class="tw-font-semibold tw-text-sm tw-text-gray-400 pb-1 tw-block form-label">Password
                                    Confirmation</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="tw-border tw-rounded-lg tw-px-3 py-2 mt-1 tw-text-sm tw-w-full dark:tw-bg-gray-700 tw-text-black dark:tw-text-white focus:tw-border-blue-500 focus:tw-ring-4 focus:tw-ring-blue-500" />
                                <span class="tw-text-red-500 tw-text-xs mt-1 " id="password_confirmation-error"></span>

                            </div>

                        </div>
                        <div class="mt-3">
                            <button type="submit" id="reset"
                                class="py-2 px-4 tw-bg-blue-600 hover:tw-bg-blue-700 focus:tw-ring-blue-500 focus:tw-ring-offset-blue-200 tw-text-white tw-w-full tw-transition tw-ease-in tw-duration-200 tw-text-center tw-text-base tw-font-semibold tw-shadow-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 rounded">
                                Reset Password
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </form>

        @include('layouts.loader')

        <script>
            console.log($('#email').val());
            $("#loader").hide();
            $('#reset-form').submit(function(e) {
                e.preventDefault();
                $("#loader").show();

                let formData = {
                    token: '{{ $token }}',
                    email: '{{ $email }}',
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                    _token: '{{ csrf_token() }}'
                }

                // console.table(email, password, token);

                //ajax
                $.ajax({
                    url: `/password/reset`,
                    type: "PUT",
                    cache: false,
                    data: formData,
                    success: function(response) {
                        $("#loader").hide();
                        //show success message
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#password').val('');
                            $('#password_confirmation').val('');

                            $('.tw-text-red-500').text('');
                            setTimeout(() => {
                                window.location.href = '/';
                            }, 1000);

                        } else {
                            // console.log(response);
                            let errors = response.message;
                            $('#email-error').text(errors.email ? errors.email[0] : '');
                            if (errors.password[0] == 'The password field confirmation does not match.') {
                                $('#password_confirmation-error').text(errors.password ? errors
                                    .password[0] : '');
                            } else {
                                $('#password-error').text(errors.password ? errors.password[0] : '');
                            }
                            $('#password').val('');
                            $('#password_confirmation').val('');

                        }
                    },
                    error: function(error) {

                    }
                });
            });
        </script>
    </body>

</html>
