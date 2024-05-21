<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>register</title>
    </head>

    <body>
        <form action="/register" method="post">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
            @error('name')
                <div>{{ $message }}</div>
            @enderror
            <br>
            <label for="phone">No. Hp</label>
            <input type="text" name="phone" id="phone">
            @error('phone')
                <div>{{ $message }}</div>
            @enderror
            <br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            @error('email')
                <div>{{ $message }}</div>
            @enderror
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            @error('password')
                @if ($message !== 'The password field confirmation does not match.')
                    <div>{{ $message }}</div>
                @endif
            @enderror
            <br>
            <label for="password_confirmation">Confirmation Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
            @error('password')
                @if ($message === 'The password field confirmation does not match.')
                    <div>{{ $message }}</div>
                @endif
            @enderror
            <br>
            <input type="submit" value="submit">
        </form>
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
    </body>

</html>
