@extends('layout.admin.dashboard')

@section('title', 'Edit Data Staff') {{-- GANTI JUDUL --}}

@section('content')
    <div class="container-fluid p-4">
        <h1 class="h3 fw-semibold mb-4">Edit Data Staff: {{ $user->name }}</h1> {{-- GANTI VARIABEL --}}

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST"> {{-- GANTI ROUTE & VARIABEL --}}
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name) }}" required> {{-- GANTI VARIABEL --}}
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" value="{{ old('username', $user->username) }}" required> {{-- GANTI VARIABEL --}}
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email) }}" required> {{-- GANTI VARIABEL --}}
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                        {{-- GANTI VARIABEL --}}
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password Baru (Opsional)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role (Izin Akses) <span
                                class="text-danger">*</span></label> {{-- GANTI NAME & ID --}}
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                            required> {{-- GANTI NAME & ID --}}
                            <option value="global_admin"
                                {{ old('role', $user->role) == 'global_admin' ? 'selected' : '' }}>Global Admin</option>
                            {{-- GANTI VARIABEL & VALUE --}}
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option> {{-- GANTI VARIABEL & VALUE --}}
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="staff_status" class="form-label">Status Staff <span class="text-danger">*</span></label>
                        <select class="form-select @error('staff_status') is-invalid @enderror" id="staff_status"
                            name="staff_status" required>
                            <option value="" disabled
                                {{ old('staff_status', $user->staff_status ?? '') == '' ? 'selected' : '' }}>Pilih Status
                                Staff</option>
                            <option value="Dosen"
                                {{ old('staff_status', $user->staff_status ?? '') == 'Dosen' ? 'selected' : '' }}>Dosen
                            </option> {{-- GANTI VARIABEL --}}
                            <option value="Mahasiswa"
                                {{ old('staff_status', $user->staff_status ?? '') == 'Mahasiswa' ? 'selected' : '' }}>
                                Mahasiswa</option> {{-- GANTI VARIABEL --}}
                            <option value="TPA"
                                {{ old('staff_status', $user->staff_status ?? '') == 'TPA' ? 'selected' : '' }}>TPA
                            </option> {{-- GANTI VARIABEL --}}
                        </select>
                        @error('staff_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a> {{-- GANTI ROUTE --}}
                </form>
            </div>
        </div>
    </div>
@endsection
