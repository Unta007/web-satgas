@extends('layout.auth')

@section('title', 'Daftar Akun - Satgas PPKS Kampus Surabaya')

@section('content')
    <div class="login-container">
        {{-- PANEL KIRI DENGAN GAMBAR DAN TEKS (SAMA DENGAN LOGIN) --}}
        <div class="login-image-panel">
            <div class="image-panel-content">
                <h1>Satgas PPKS Kampus Surabaya</h1>
                <p>
                    Bergabunglah dengan kami dalam menciptakan lingkungan kampus yang aman, nyaman, dan bebas dari kekerasan dalam bentuk apapun.
                </p>
            </div>
        </div>

        {{-- PANEL KANAN DENGAN FORM REGISTER --}}
        <div class="login-form-panel">
            <div class="login-form-wrapper">
                {{-- Ganti src dengan path logo Anda --}}
                <img src="{{ Vite::asset('resources/images/tel-u.png') }}" alt="Telkom University Surabaya Logo" class="login-logo">

                <h2>Buat Akun Baru</h2>
                <p class="subtitle">Silakan isi data diri Anda untuk mendaftar.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Input Username --}}
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-custom @error('username') is-invalid @enderror" id="username"
                               name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                        @error('username')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Email --}}
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" id="email" name="email"
                               value="{{ old('email') }}" placeholder="Alamat Email" required>
                        @error('email')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Nomor Telepon --}}
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-custom @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number"
                               value="{{ old('phone_number') }}" placeholder="Nomor Telepon" required>
                        @error('phone_number')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Password dengan Tombol Show/Hide --}}
                    <div class="mb-3 password-wrapper">
                        <input type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" id="password" name="password"
                               placeholder="Password" required>
                        <i class="bi bi-eye-slash-fill password-toggle-icon" id="togglePassword"></i>
                        @error('password')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Konfirmasi Password --}}
                    <div class="mb-4 password-wrapper">
                        <input type="password" class="form-control form-control-custom" id="password-confirm" name="password_confirmation"
                               placeholder="Konfirmasi Password" required>
                        <i class="bi bi-eye-slash-fill password-toggle-icon" id="togglePasswordConfirm"></i>
                    </div>

                    {{-- Tombol Register --}}
                    <button type="submit" class="btn btn-login">Daftar</button>
                </form>

                {{-- Link Login --}}
                <p class="register-link mt-4">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/auth.js')
@endpush


