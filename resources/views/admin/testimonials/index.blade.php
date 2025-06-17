@extends('layout.admin.dashboard')

@section('title', 'Kelola Testimoni')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3 fw-semibold p-2 mb-0">Daftar Testimoni</h1>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                Tambah Testimoni
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="testimonialsTable" class="table table-hover align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Kutipan</th>
                            <th>Tanggal Dibuat</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $testimonial)
                            <tr>
                                <td>"{{ Str::limit($testimonial->quote, 50) }}"</td>
                                {{-- <td>{{ $testimonial->author }}</td> --}} {{-- <<< BARIS INI DIHAPUS --}}
                                <td data-order="{{ $testimonial->created_at->timestamp }}">
                                    {{ $testimonial->created_at->format('Y-m-d') }}
                                </td>
                                <td class="text-center">
                                    @if ($testimonial->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('admin.testimonials.toggle', $testimonial) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                title="{{ $testimonial->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i
                                                    class="bi {{ $testimonial->is_active ? 'bi-toggle-on text-success' : 'bi-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                            method="POST" class="d-inline delete-testimonial-form">
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

@push('page-scripts')
    @vite('resources/js/admin-testimonials.js')
@endpush
