@extends('layout.admin.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-fluid p-4">

        <h1 class="h3 fw-semibold mb-4">Profil Saya</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="text-center mb-4">
                    <img src="{{ $user->profile_photo_url }}" alt="Foto Profil {{ $user->name }}" class="rounded-circle"
                        style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <form action="{{ route('admin.profile.update_photo') }}" method="POST" enctype="multipart/form-data"
                    class="mb-5 text-center">
                    @csrf
                    <div class="mb-3 d-inline-block">
                        <label for="photo" class="form-label">Ubah Foto Profil</label>
                        <input class="form-control form-control-sm @error('photo') is-invalid @enderror" type="file"
                            id="photo" name="photo" required>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-danger btn-sm" style="background-color: #A40E0E; border-color: #A40E0E;">Simpan Foto</button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly
                            disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" value="{{ $user->username }}" readonly
                            disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Akses Staff (Role)</label>
                        <input type="text" id="role" class="form-control" value="{{ ucfirst($user->role) }}"
                            readonly disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="staff_status" class="form-label">Status Staff</label>
                        <input type="text" id="staff_status" class="form-control"
                            value="{{ $user->staff_status ?? 'N/A' }}" readonly disabled>
                    </div>
                </div>

                <hr class="my-4">

                <h5>Ubah Password</h5>
                <form action="{{ route('admin.profile.update_password') }}" method="POST" id="changePasswordForm">
                    @csrf
                    @method('PUT')

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

                    <button type="submit" class="btn btn-danger" style="background-color: #A40E0E; border-color: #A40E0E;">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/admin-profile.js')
@endpush
