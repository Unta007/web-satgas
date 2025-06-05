@extends('layout.admin.dashboard')

@section('title', 'Tambah Staff Baru') {{-- GANTI JUDUL --}}

@section('content')
<div class="container-fluid p-4">
    <h1 class="h3 fw-semibold mb-4">Tambah Staff Baru</h1> {{-- GANTI JUDUL --}}

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST"> {{-- GANTI ROUTE --}}
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role (Izin Akses) <span class="text-danger">*</span></label> {{-- GANTI NAME & ID --}}
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required> {{-- GANTI NAME & ID --}}
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                        <option value="global_admin" {{ old('role') == 'global_admin' ? 'selected' : '' }}>Global Admin</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        {{-- User biasa tidak dibuat dari sini, tapi bisa ditambahkan jika perlu --}}
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="staff_status" class="form-label">Status Staff <span class="text-danger">*</span></label>
                    <select class="form-select @error('staff_status') is-invalid @enderror" id="staff_status" name="staff_status" required>
                        <option value="" disabled {{ old('staff_status') ? '' : 'selected' }}>Pilih Status Staff</option>
                        <option value="Dosen" {{ old('staff_status') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="Mahasiswa" {{ old('staff_status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="TPA" {{ old('staff_status') == 'TPA' ? 'selected' : '' }}>TPA</option>
                    </select>
                    @error('staff_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a> {{-- GANTI ROUTE --}}
            </form>
        </div>
    </div>
</div>
@endsection
