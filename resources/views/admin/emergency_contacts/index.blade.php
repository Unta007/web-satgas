@extends('layout.admin.dashboard')

@section('title', 'Kelola Kontak Darurat')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3 fw-semibold p-2 mb-0">Daftar Kontak Darurat</h1>
            <a href="{{ route('admin.emergency-contacts.create') }}" class="btn btn-primary">
                Tambah Kontak
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="emergencyContactsTable" class="table table-hover align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Urutan</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Info Kontak</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 2. Ganti @forelse menjadi @foreach dan hapus @empty --}}
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->order }}</td>
                                <td><i class="bi {{ $contact->icon }} me-2"></i>{{ $contact->name }}</td>
                                <td>{{ $contact->type }}</td>
                                <td>{{ $contact->contact_info }}</td>
                                <td class="text-center">
                                    @if ($contact->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('admin.emergency-contacts.toggle', $contact) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                title="{{ $contact->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i
                                                    class="bi {{ $contact->is_active ? 'bi-toggle-on text-success' : 'bi-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.emergency-contacts.edit', $contact) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- 3. Tambahkan class delete-contact-form pada form hapus --}}
                                        <form action="{{ route('admin.emergency-contacts.destroy', $contact) }}"
                                            method="POST" class="d-inline delete-contact-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- 4. Muat file JS yang baru --}}
@push('page-scripts')
    @vite('resources/js/admin-emergency-contacts.js')
@endpush
