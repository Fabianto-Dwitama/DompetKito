<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Dasbor Admin</title></head>
<body>
    <h2>Halaman Khusus Admin</h2>
    <p>Halo, {{ auth()->user()->name }}</p>
    <a href="{{ route('profile.edit') }}">Edit Profil Admin</a> |
    <a href="{{ route('dashboard') }}">Coba buka halaman User (Harus Diblokir 403)</a>
    <br><br>
    <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit">Logout</button></form>
</body>
</html>