@extends('layout.app')

@section('title', 'Login')

@section('content')
    <div class="container mt-5">
        <h2>Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="login" class="form-label">Email or Phone Number</label>
                <input type="text"
                    class="form-control" id="login" name="login" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <a href="{{ route('password.request') }}">Lupa Password?</a>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3"> Don't have an account? <a href="{{ route('register') }}">Register here</a>.</p>
    </div>
@endsection
