<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>login</title>
    </head>

    <body>
        <form action="/login" method="post">
            @csrf
            <label for="email">Email</label>
            <input type="email" name="email" id="email"><br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="submit">
        </form>

        <a href="http://127.0.0.1:8000/auth/google/redirect">Login With Google</a>
    </body>

</html>
