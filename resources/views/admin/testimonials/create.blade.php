@extends('layout.admin.dashboard')

@section('title', 'Tambah Testimoni Baru')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="h3 fw-semibold p-2 mb-0">Tambah Testimoni</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.testimonials.store') }}" method="POST">
                @csrf
                @include('admin.testimonials._form', ['buttonText' => 'Tambah Testimoni'])
            </form>
        </div>
    </div>
@endsection
