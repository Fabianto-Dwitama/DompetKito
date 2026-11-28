<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login</title></head>
<body>
    <h2>Masuk ke Akun</h2>
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
    @if($errors->any()) <p style="color:red">{{ $errors->first() }}</p> @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div><label>Email:</label><br><input type="email" name="email" value="{{ old('email') }}" required></div><br>
        <div><label>Kata Sandi:</label><br><input type="password" name="password" required></div><br>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
</body>
</html>