<!DOCTYPE html>
<html lang="en" id="html" class="tw-dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    @vite(['resources/scss/app.scss', 'resources/scss/themes/dark/app-dark.scss', 'resources/js/initTheme.js', 'resources/js/app.js', 'resources/js/components/dark.js', 'resources/css/app.css'])
    <link rel="shortcut icon" href="{{ asset('/static/images/logo/favicon.svg') }}" type="image/x-icon">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        #main-navbar.bg-main-navbar {
            background-color: #171722;
        }
    </style>
    @yield('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            @include('layouts.partials.navbar-user')

            <div class="content-wrapper container">
                @yield('main-content')
            </div>

            @include('layouts.partials.footer')
        </div>
    </div>


    {{-- @vite(['resources/js/pages/dashboard.js'])
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
    <script>
        let triggerBurger = document.getElementById('trigger-burger');
        let mainNavbar = document.getElementById('main-navbar');
        let html = document.getElementById('html');

        triggerBurger.addEventListener('click', () => {
            document.getElementById('main-navbar').classList.toggle('active');
            html.getAttribute('data-bs-theme') === 'dark' ? mainNavbar.classList.add('bg-main-navbar') : mainNavbar
                .classList
                .remove('bg-main-navbar');
        });


        html.addEventListener('change', () => {
            if (html.getAttribute('data-bs-theme') === 'dark') {
                // mainNavbar.style.backgroundColor = '#171722';
                mainNavbar.classList.add('bg-main-navbar');
            } else {
                mainNavbar.classList.remove('bg-main-navbar');
                // mainNavbar.style.backgroundColor = '#f5f7fc';
            }
        })
    </script>

    @yield('js')

</body>

</html>