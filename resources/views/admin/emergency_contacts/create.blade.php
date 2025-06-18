@extends('layout.admin.dashboard')
@section('title', 'Tambah Kontak Darurat')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="h3 fw-semibold p-2 mb-0">Tambah Kontak Darurat Baru</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.emergency-contacts.store') }}" method="POST">
                @csrf
                @include('admin.emergency_contacts._form', ['buttonText' => 'Tambah Kontak'])
            </form>
        </div>
    </div>
@endsection
