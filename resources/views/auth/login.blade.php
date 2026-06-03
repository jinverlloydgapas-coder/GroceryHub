@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-4">
            <div class="auth-card">
                <div class="auth-header">
                    <i class="fas fa-sign-in-alt auth-header-icon"></i>
                    <h1>Sign In</h1>
                    <p>Welcome back to GroceryHub</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email Address
                        </label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                        @error('email')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2" style="color: var(--primary);"></i>Password
                        </label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Enter your password">
                        @error('password')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary-guest">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Don't have an account yet? 
                        <a href="{{ route('signup') }}">Create one</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
