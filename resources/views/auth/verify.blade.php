@extends('layout.auth')

@section('title', 'Verifikasi Email Anda')

@section('content')
    <div class="login-container">
        {{-- PANEL KIRI DENGAN GAMBAR DAN TEKS (SAMA DENGAN SEBELUMNYA) --}}
        <div class="login-image-panel">
            <div class="image-panel-content">
                <h1>Satu Langkah Lagi...</h1>
                <p>
                    Kami telah mengirimkan tautan verifikasi ke alamat email Anda untuk memastikan keamanan akun Anda.
                </p>
            </div>
        </div>

        {{-- PANEL KANAN DENGAN INFORMASI VERIFIKASI --}}
        <div class="login-form-panel">
            <div class="login-form-wrapper text-center"> {{-- Menggunakan text-center untuk merapikan konten --}}

                <h2 class="mb-3">Verifikasi Alamat Email Anda</h2>

                {{-- Pesan Sukses jika email baru saja dikirim ulang --}}
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        Tautan verifikasi baru telah berhasil dikirimkan ke alamat email Anda.
                    </div>
                @endif

                <p class="subtitle">
                    Sebelum melanjutkan, silakan periksa kotak masuk email Anda untuk link verifikasi.
                    Tautan telah dikirim ke: <br><strong>{{ auth()->user()->email }}</strong>
                </p>

                <p class="mt-4">
                    Tidak menerima email?
                </p>

                {{-- Tombol untuk Kirim Ulang Email --}}
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-login w-100">
                       Kirim Ulang Email Verifikasi
                    </button>
                </form>

                {{-- Tombol untuk Logout (Penting untuk UX jika user salah email) --}}
                <div class="mt-4">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <p class="register-link mb-0">
                        Salah akun? <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           Keluar (Logout)
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/auth.js')
@endpush
