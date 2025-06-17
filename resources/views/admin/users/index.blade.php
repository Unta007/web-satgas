@extends('layout.admin.dashboard')

@section('title', 'Kelola Staff') {{-- GANTI JUDUL --}}

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3 fw-semibold p-2 mb-0">Kelola Staff</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah Staff</a> {{-- GANTI ROUTE & TEKS --}}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover align-middle" style="width:100%"> {{-- GANTI ID TABEL --}}
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role (Izin Akses)</th> {{-- GANTI HEADER --}}
                            <th>Status Staff</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            {{-- GANTI VARIABEL LOOP --}}
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td> {{-- TAMPILKAN role --}}
                                <td>{{ $user->staff_status }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary"
                                        title="Edit"> {{-- GANTI ROUTE & VARIABEL --}}
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="d-inline delete-user-form"> {{-- GANTI ROUTE & CLASS & VARIABEL --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/user-list.js') {{-- GANTI NAMA FILE JS --}}
@endpush
