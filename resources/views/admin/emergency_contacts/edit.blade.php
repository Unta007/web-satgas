@extends('layout.admin.dashboard')
@section('title', 'Edit Kontak Darurat')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Kontak Darurat</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.emergency-contacts.update', $emergencyContact) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.emergency_contacts._form', [
                    'contact' => $emergencyContact,
                    'buttonText' => 'Simpan Perubahan',
                ])
            </form>
        </div>
    </div>
@endsection
