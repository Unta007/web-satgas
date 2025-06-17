@extends('layout.admin.dashboard')

@section('title', 'Edit Testimoni')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Testimoni</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.testimonials._form', ['buttonText' => 'Simpan Perubahan'])
            </form>
        </div>
    </div>
@endsection
