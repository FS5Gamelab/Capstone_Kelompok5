<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }} - {{ config('app.name') }}</title>
        @vite(['resources/scss/app.scss', 'resources/scss/themes/dark/app-dark.scss', 'resources/js/initTheme.js', 'resources/js/app.js', 'resources/css/app.css'])
        <link rel="shortcut icon" href="{{ asset('/static/images/logo/favicon.svg') }}" type="image/x-icon">

        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

        @yield('css')
        <style>
            trix-toolbar [data-trix-button-group ="file-tools"] {
                display: none;
            }

            trix-editor {
                background-color: white;
            }

            .trix-button-group {
                background-color: white;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <div id="app">
            @yield('sidebar')

            <div id="main" class='layout-navbar navbar-fixed'>
                <header>
                    @include('layouts.partials.navbar')
                </header>
                <div id="main-content">
                    @yield('content')
                </div>
                @include('layouts.partials.footer-admin')
            </div>
        </div>



        @yield('js')
    </body>

</html>
