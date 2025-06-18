@extends('layout.auth')

@section('title', 'Atur Ulang Password')

@section('content')
    <div class="login-container">
        {{-- PANEL KIRI DENGAN GAMBAR DAN TEKS --}}
        <div class="login-image-panel">
            <div class="image-panel-content">
                <h1>Buat Password Baru</h1>
                <p>
                    Pastikan password baru Anda kuat dan mudah diingat untuk menjaga keamanan akun Anda.
                </p>
            </div>
        </div>

        {{-- PANEL KANAN DENGAN FORM --}}
        <div class="login-form-panel">
            <div class="login-form-wrapper">

                <h2 class="text-center">Atur Ulang Password</h2>
                <p class="subtitle text-center">Buat password baru untuk akun Anda.</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Field Email (Readonly) --}}
                    <div class="mb-3">
                         <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror"
                                name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                        @error('email')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Field Password Baru --}}
                    <div class="mb-3 password-wrapper">
                        <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror"
                               name="password" placeholder="Masukkan password baru" required autocomplete="new-password">
                        <i class="bi bi-eye-slash-fill password-toggle-icon" id="togglePassword"></i>
                         @error('password')
                            <div class="invalid-feedback text-start">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Field Konfirmasi Password Baru --}}
                    <div class="mb-4 password-wrapper">
                         <input id="password-confirm" type="password" class="form-control form-control-custom"
                                name="password_confirmation" placeholder="Konfirmasi password baru" required autocomplete="new-password">
                         <i class="bi bi-eye-slash-fill password-toggle-icon" id="togglePasswordConfirm"></i>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/auth.js')
@endpush
