@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-check" style="font-size:3rem;color:#1a1a2e;"></i>
                    <h3 class="mt-2">Grievance Portal</h3>
                    <p class="text-muted">Sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-2">Sign In</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </p>
                <hr>
                <p class="text-center text-muted small mb-0">
                    <strong>Demo:</strong> admin@grievance.gov.in / password
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
