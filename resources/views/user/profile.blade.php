@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="profile-container">

        <header class="profile-header">
            <label for="photo" class="profile-avatar" title="Klik untuk ubah foto">
                <img src="{{ $user->profile_photo_url }}" alt="Foto Profil {{ $user->name }}" id="photo-preview" class="profile-avatar-img">
                <div class="avatar-overlay">
                    <i class="bi bi-camera-fill"></i>
                </div>
            </label>
            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
            </div>
        </header>

        {{-- Menampilkan notifikasi --}}
        @if (session('success') || session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') ?? session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- BAGIAN BODY PROFIL (NAVIGASI + KONTEN) --}}
        <div class="profile-body">
            {{-- NAVIGASI SISI KIRI --}}
            <nav class="profile-nav">
                <ul>
                    <li><a href="#" class="is-active" data-target="#akun"><i class="bi bi-person-gear"></i> Pengaturan Akun</a></li>
                    <li><a href="#" data-target="#laporan"><i class="bi bi-file-earmark-text"></i> Riwayat Laporan</a></li>
                </ul>
            </nav>

            {{-- KONTEN DINAMIS SISI KANAN --}}
            <div class="profile-content">
                {{-- KONTEN PENGATURAN AKUN --}}
                <section id="akun" class="profile-content-section is-active">
                    <h3>Pengaturan Akun</h3>

                    {{-- Form Ubah Foto --}}
                    <div class="form-section">
                        <h4>Foto Profil</h4>
                        <form action="{{ route('profile.update_photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="photo" class="form-label">Pilih foto baru</label>
                                <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" required accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Foto</button>
                        </form>
                    </div>
                    <hr class="my-4">
                    {{-- Form Ubah Email --}}
                    <div class="form-section">
                        <h4>Informasi Akun</h4>
                        <form action="{{ route('profile.update_details') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="current_password_for_details" class="form-label">Password Saat Ini (untuk konfirmasi)</label>
                                <input type="password" class="form-control @error('current_password_for_details') is-invalid @enderror" id="current_password_for_details" name="current_password_for_details" required>
                                @error('current_password_for_details')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                    <hr class="my-4">
                    {{-- Form Ubah Password --}}
                    <div class="form-section">
                        <h4>Ubah Password</h4>
                         <form action="{{ route('profile.update_password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                                     @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger">Ubah Password & Logout</button>
                        </form>
                    </div>
                </section>

                {{-- KONTEN RIWAYAT LAPORAN --}}
                <section id="laporan" class="profile-content-section">
                    <h3>Riwayat Laporan Anda</h3>
                    @if ($reports->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-file-earmark-x fs-1"></i>
                            <p class="mt-3">Anda belum pernah membuat laporan.</p>
                            <a href="{{ route('reports.create') }}" class="btn btn-primary mt-2">Buat Laporan Pertama Anda</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $report)
                                        <tr>
                                            <td>#{{ $report->id }}</td>
                                            <td>{{ $report->created_at->format('d M Y') }}</td>
                                            <td>
                                                @php
                                                    $statusClass = 'text-secondary-emphasis bg-secondary-subtle border-secondary-subtle';
                                                    $statusText = strtoupper($report->status);
                                                    switch (strtolower($report->status)) {
                                                        case 'unread': $statusClass = 'text-info-emphasis bg-info-subtle border border-info-subtle'; break;
                                                        case 'review': $statusClass = 'text-primary-emphasis bg-primary-subtle border-primary-subtle'; break;
                                                        case 'ongoing': $statusClass = 'text-warning-emphasis bg-warning-subtle border-warning-subtle'; break;
                                                        case 'solved': $statusClass = 'text-success-emphasis bg-success-subtle border-success-subtle'; break;
                                                        case 'denied': $statusClass = 'text-danger-emphasis bg-danger-subtle border-danger-subtle'; break;
                                                    }
                                                @endphp
                                                <span class="badge rounded-pill {{ $statusClass }}">{{ $statusText }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-outline-dark">Lihat Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/user-profile.js')
@endpush
