@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="mb-4">
            <h1 class="h3 fw-semibold mb-1">
                <i class="fas fa-user-edit me-2" style="color: var(--primary);"></i>Edit User
            </h1>
            <p class="text-muted">Update user information and credentials</p>
        </div>

        <div class="card border-0">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-500" for="name">
                            <i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name
                        </label>
                        <input type="text" id="name" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required placeholder="John Doe">
                        @error('name')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500" for="email">
                            <i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email Address
                        </label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required placeholder="user@example.com">
                        @error('email')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500" for="password">
                            <i class="fas fa-lock me-2" style="color: var(--primary);"></i>Password 
                            <span class="text-muted small">(leave blank to keep current)</span>
                        </label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Min 8 chars: 1 upper, 1 lower, 1 number, 1 symbol">
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>If changing: Must contain Uppercase, Lowercase, Number, Special char (@$!%*?&)
                        </small>
                        @error('password')<div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-500" for="password_confirmation">
                            <i class="fas fa-shield-alt me-2" style="color: var(--primary);"></i>Confirm Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" placeholder="Repeat new password if changing">
                    </div>

                    <div class="d-grid gap-2 d-sm-flex">
                        <button type="submit" class="btn btn-primary btn-lg fw-600 rounded-3">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg rounded-3">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
