login berhasil
{{ auth()->user()->customer }}

<form action="/logout" method="post">
    @csrf
    <input type="submit" value="logout">
</form>
