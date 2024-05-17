login berhasil
{{ auth()->user()->role }}

<form action="/logout" method="post">
    @csrf
    <input type="submit" value="logout">
</form>
