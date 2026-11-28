<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Kelola Profil</title></head>
<body>
    <h2>Kelola Profil ({{ ucfirst($user->role) }})</h2>
    <a href="{{ url('/') }}">Kembali ke Dasbor</a>
    <hr>

    <h3>Ubah Data Diri</h3>
    @if(session('success_profile')) <p style="color:green">{{ session('success_profile') }}</p> @endif
    @if($errors->has('name') || $errors->has('email')) <p style="color:red">{{ $errors->first() }}</p> @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')
        <div><label>Nama:</label><br><input type="text" name="name" value="{{ old('name', $user->name) }}" required></div><br>
        <div><label>Email:</label><br><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div><br>
        <button type="submit">Simpan Profil</button>
    </form>
    <hr>

    <h3>Ganti Kata Sandi</h3>
    @if(session('success_password')) <p style="color:green">{{ session('success_password') }}</p> @endif
    @if($errors->has('current_password') || $errors->has('password')) <p style="color:red">{{ $errors->first() }}</p> @endif

    <form method="POST" action="{{ route('profile.password') }}">
        @csrf
        @method('PUT')
        <div><label>Kata Sandi Lama:</label><br><input type="password" name="current_password" required></div><br>
        <div><label>Kata Sandi Baru:</label><br><input type="password" name="password" required></div><br>
        <div><label>Konfirmasi Kata Sandi Baru:</label><br><input type="password" name="password_confirmation" required></div><br>
        <button type="submit">Ubah Kata Sandi</button>
    </form>
</body>
</html>