<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Verify Email</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    </head>

    <body>

        <div class="container mt-4">

            <div class="d-flex align-items-center justify-content-center ">
                <img src="{{ asset('/static/images/logo/logo.svg') }}" alt=""
                    class="img-fluid tw-pt-4 sm:tw-pt-0">
            </div>
            <h2 class="mt2">Hey {{ $name }},</h2>
            <div class="alert alert-info d-flex align-items-center justify-content-center">
                You are receiving this email because you must verify your email address.
                <a href="http://localhost:8000/verify-email/{{ $id }}/{{ $token }}"
                    class="btn btn-primary">
                    Verify Email
                </a>
            </div>
        </div>
    </body>

</html>
