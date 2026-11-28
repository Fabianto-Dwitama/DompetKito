<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencatatan Keuangan - Laptop</title>
</head>
<body style="font-family: sans-serif; padding: 40px; background: #f0f4f8;">
    <h1>Ini Tampilan LAPTOP (Desktop)</h1>
    <p>Area kerja Orang 2.</p>
    <a href="?mode=mobile">Coba pindah ke mode HP</a>
    <a href="{{ route('profile.edit') }}">Edit Profil Admin</a> |
    <a href="{{ route('dashboard') }}">Coba buka halaman User (Harus Diblokir 403)</a>
    <br><br>
    <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit">Logout</button></form>
</body>
</html>