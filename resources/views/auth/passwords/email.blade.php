@extends('layout.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="login-container">
        {{-- PANEL KIRI DENGAN GAMBAR DAN TEKS --}}
        <div class="login-image-panel">
            <div class="image-panel-content">
                <h1>Lupa Password?</h1>
                <p>
                    Jangan khawatir. Masukkan alamat email Anda yang terdaftar dan kami akan mengirimkan tautan untuk
                    mengatur ulang password Anda.
                </p>
            </div>
        </div>

        {{-- PANEL KANAN DENGAN FORM --}}
        <div class="login-form-panel">
            <div class="login-form-wrapper text-center">

                <h2 class="mb-3">Lupa Password Anda?</h2>
                <p class="subtitle">
                    Masukkan email Anda di bawah ini untuk memulai proses reset.
                </p>

                {{-- Pesan Sukses setelah link dikirim --}}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <input id="email" type="email"
                            class="form-control form-control-custom @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="Masukkan alamat email Anda" required
                            autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        Kirim Tautan Reset Password
                    </button>
                </form>

                <p class="register-link mt-4">
                    Ingat password Anda? <a href="{{ route('login') }}">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
