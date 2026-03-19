@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5">
  <div class="row g-0 shadow rounded-4 overflow-hidden" style="max-width: 900px; width: 100%;">

    {{-- Left Branding Panel --}}
    <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-center align-items-center text-white p-5" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
      <i class="bi bi-chat-square-heart-fill display-1 mb-3"></i>
      <h2 class="fw-bold mb-2">Connectify</h2>
      <p class="text-center" style="opacity: .85;">Connect with friends, share moments, and discover what's happening around you.</p>
    </div>

    {{-- Login Form --}}
    <div class="col-lg-7 bg-white p-4 p-md-5">
      <div class="mb-4">
        <h4 class="fw-bold mb-1">Welcome Back</h4>
        <p class="text-muted mb-0">Sign in to continue to Connectify</p>
      </div>

      <form method="POST" action="{{ route('auth.login') }}">
        @csrf

        <div class="mb-3">
          <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="you@example.com" required />
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required />
            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3">
          <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
        </button>

        <p class="text-center text-muted mb-0">
          Don't have an account? <a href="{{ route('auth.registration') }}" class="fw-semibold text-decoration-none">Create one</a>
        </p>
      </form>
    </div>

  </div>
</div>
@endsection