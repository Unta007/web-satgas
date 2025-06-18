@extends('layout.auth')

@section('title', 'Konfirmasi Password')

@section('content')
    <div class="login-container">
        {{-- PANEL KIRI DENGAN GAMBAR DAN TEKS --}}
        <div class="login-image-panel">
            <div class="image-panel-content">
                <h1>Akses Aman</h1>
                <p>
                    Demi keamanan, kami perlu memastikan bahwa ini benar-benar Anda sebelum melanjutkan.
                </p>
            </div>
        </div>

        {{-- PANEL KANAN DENGAN FORM --}}
        <div class="login-form-panel">
            <div class="login-form-wrapper text-center">

                <h2 class="mb-3">Konfirmasi Password Anda</h2>
                <p class="subtitle">
                   Silakan masukkan kembali password Anda untuk melanjutkan.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4 password-wrapper">
                        <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror"
                               name="password" placeholder="Masukkan password Anda" required autocomplete="current-password">
                        <i class="bi bi-eye-slash-fill password-toggle-icon" id="togglePassword"></i>
                        @error('password')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        Konfirmasi Password
                    </button>

                    @if (Route::has('password.request'))
                        <p class="register-link mt-4">
                            <a href="{{ route('password.request') }}">Lupa Password Anda?</a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/auth.js')
@endpush
