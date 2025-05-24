@extends('layout.app')

@section('title', 'Submit Report')

@section('content')
    <div class="container mt-5">
        <h1>Submit a Report</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @auth
            <form action="{{ route('report.create') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="what_happened" class="form-label">What happened?</label>
                    <textarea class="form-control" id="what_happened" name="what_happened" rows="4"
                        required>{{ old('what_happened') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="when_happened" class="form-label">When did it happen?</label>
                    <input type="datetime-local" class="form-control" id="when_happened" name="when_happened"
                        value="{{ old('when_happened') }}">
                </div>

                <div class="mb-3">
                    <label for="report_role" class="form-label">Your role</label>
                    <select class="form-select" id="report_role" name="report_role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="mahasiswa" {{ old('report_role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="staff" {{ old('report_role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="dosen" {{ old('report_role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="predator_role" class="form-label">Predator's role</label>
                    <select class="form-select" id="predator_role" name="predator_role" required>
                        <option value="" disabled selected>Select predator's role</option>
                        <option value="mahasiswa" {{ old('predator_role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="staff" {{ old('predator_role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="dosen" {{ old('predator_role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="evidence" class="form-label">Evidence (optional, max 2MB)</label>
                    <input class="form-control" type="file" id="evidence" name="evidence" accept="image/*,application/pdf">
                </div>

                <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>
        @else
            <div class="alert alert-warning">
                Please <a href="{{ route('login') }}">login</a> to submit a report.
            </div>
        @endauth
    </div>
@endsection