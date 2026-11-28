<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Daftar Akun</title></head>
<body>
    <h2>Daftar Akun Baru</h2>
    @if($errors->any())
        <ul style="color:red">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div><label>Nama Lengkap:</label><br><input type="text" name="name" value="{{ old('name') }}" required></div><br>
        <div><label>Email:</label><br><input type="email" name="email" value="{{ old('email') }}" required></div><br>
        <div><label>Kata Sandi (min. 6 karakter):</label><br><input type="password" name="password" required></div><br>
        <div><label>Ulangi Kata Sandi:</label><br><input type="password" name="password_confirmation" required></div><br>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</body>
</html>