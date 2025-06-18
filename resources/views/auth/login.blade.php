@extends('layout.auth')

@section('title', 'Login - Satgas PPKS Kampus Surabaya')

@section('content')
    <div class="login-container">
        {{-- PANEL KIRI DENGAN GAMBAR DAN TEKS --}}
        <div class="login-image-panel">
            <div class="image-panel-content">
                <h1>Satgas PPKS Universitas Telkom Surabaya</h1>
                <p>
                    Mari ciptakan lingkungan yang aman dan nyaman untuk seluruh civitas akademika.
                </p>
            </div>
        </div>

        {{-- PANEL KANAN DENGAN FORM LOGIN --}}
        <div class="login-form-panel">
            <div class="login-form-wrapper">
                <img src="{{ Vite::asset('resources/images/tel-u.png') }}" alt="Telkom University Surabaya Logo" class="login-logo">

                <h2>Selamat Datang!</h2>
                <p class="subtitle">Masuk untuk akses akun</p>

                {{-- Menampilkan error jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger p-2 mb-3" style="font-size: 0.9rem;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Input Email atau Nomor Telepon --}}
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-custom" id="login" name="login"
                            value="{{ old('login') }}" placeholder="Masukkan email atau nomor telepon" required autofocus>
                    </div>

                    {{-- Input Password dengan Tombol Show/Hide --}}
                    <div class="mb-3 password-wrapper">
                        <input type="password" class="form-control form-control-custom" id="password" name="password"
                            placeholder="Masukkan password" required>
                        <i class="bi bi-eye-slash-fill password-toggle-icon" id="togglePassword"></i>
                    </div>

                    {{-- Link Lupa Password --}}
                    <a href="{{ route('password.request', []) }}" class="forgot-password-link">Lupa Password?</a>

                    {{-- Tombol Masuk --}}
                    <button type="submit" class="btn btn-login">Masuk</button>
                </form>

                {{-- Link Daftar --}}
                <p class="register-link">
                    Belum punya akun? <a href="{{ route('register', []) }}">Daftar</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/auth.js')
@endpush
