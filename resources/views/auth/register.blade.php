@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-4">
            <div class="auth-card">
                <div class="auth-header">
                    <i class="fas fa-user-plus auth-header-icon"></i>
                    <h1>Create Account</h1>
                    <p>Join GroceryHub and start shopping</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                        @error('name')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email Address
                        </label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="you@example.com">
                        @error('email')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock me-2" style="color: var(--primary);"></i>Password
                        </label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Min 8 chars: 1 upper, 1 lower, 1 number, 1 symbol">
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>Must contain: Uppercase, Lowercase, Number, Special char (@$!%*?&)
                        </small>
                        @error('password')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">
                            <i class="fas fa-shield-alt me-2" style="color: var(--primary);"></i>Confirm Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repeat your password">
                    </div>

                    <button type="submit" class="btn btn-primary-guest">
                        <i class="fas fa-check me-2"></i>Create Account
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Already have an account? 
                        <a href="{{ route('login') }}">Sign in here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
