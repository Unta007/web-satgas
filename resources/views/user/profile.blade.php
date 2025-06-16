@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Profil Saya</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Kolom Kiri: Edit Profil --}}
            <div class="col-lg-5">
                {{-- Card Foto Profil --}}
                <div class="card mb-4">
                    <div class="card-header fw-bold">Foto Profil</div>
                    <div class="card-body text-center">
                        <img src="{{ $user->profile_photo_url }}" alt="Foto Profil {{ $user->name }}"
                            class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <form action="{{ route('profile.update_photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input class="form-control form-control-sm @error('photo') is-invalid @enderror"
                                    type="file" id="photo" name="photo" required>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Ubah Foto</button>
                        </form>
                    </div>
                </div>

                {{-- Card Ubah Email --}}
                <div class="card mb-4">
                    <div class="card-header fw-bold">Ubah Alamat Email</div>
                    <div class="card-body">
                        <form action="{{ route('profile.update_details') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="current_password_for_details" class="form-label">Password Saat Ini</label>
                                <input type="password"
                                    class="form-control @error('current_password_for_details') is-invalid @enderror"
                                    id="current_password_for_details" name="current_password_for_details" required
                                    placeholder="Masukkan password Anda untuk konfirmasi">
                                @error('current_password_for_details')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Email</button>
                        </form>
                    </div>
                </div>

                {{-- Card Ubah Password --}}
                <div class="card">
                    <div class="card-header fw-bold">Ubah Password</div>
                    <div class="card-body">
                        <form action="{{ route('profile.update_password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" required>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Ubah Password & Logout</button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Riwayat Laporan --}}
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header fw-bold">Riwayat Laporan Anda</div>
                    <div class="card-body">
                        @if ($reports->isEmpty())
                            <p class="text-muted text-center my-3">Anda belum pernah membuat laporan.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Laporan</th>
                                            <th>Tanggal Dibuat</th>
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
                                                        $statusClass =
                                                            'text-secondary-emphasis bg-secondary-subtle border-secondary-subtle'; // Default
                                                        $statusText = strtoupper($report->status);
                                                        switch (strtolower($report->status)) {
                                                            case 'unread':
                                                                $statusClass =
                                                                    'badge text-info-emphasis bg-info-subtle border border-info-subtle';
                                                                break;
                                                            case 'review':
                                                                $statusClass =
                                                                    'text-info-emphasis bg-info-subtle border-info-subtle';
                                                                break;
                                                            case 'ongoing':
                                                                $statusClass =
                                                                    'text-warning-emphasis bg-warning-subtle border-warning-subtle';
                                                                break;
                                                            case 'solved':
                                                                $statusClass =
                                                                    'text-success-emphasis bg-success-subtle border-success-subtle';
                                                                break;
                                                            case 'denied':
                                                                $statusClass =
                                                                    'text-danger-emphasis bg-danger-subtle border-danger-subtle'; // Bisa dibedakan dengan unread jika perlu
                                                                break;
                                                        }
                                                    @endphp
                                                    <span class="badge rounded-pill {{ $statusClass }}">
                                                        {{ $statusText }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('reports.show', $report->id) }}}"
                                                        class="btn btn-sm btn-outline-primary">Lihat
                                                        Detail</a> {{-- Ganti # dengan route detail laporan jika ada --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
