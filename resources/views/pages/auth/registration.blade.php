@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5">
  <div class="row g-0 shadow rounded-4 overflow-hidden" style="max-width: 1000px; width: 100%;">
    <div class="col-lg-4 d-none d-lg-flex flex-column justify-content-center align-items-center text-white p-5" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
      <i class="bi bi-chat-square-heart-fill display-1 mb-3"></i>
      <h2 class="fw-bold mb-2">Connectify</h2>
      <p class="text-center" style="opacity: .85;">Join the community. Share your story with the world.</p>
    </div>

    <div class="col-lg-8 bg-white p-4 p-md-5">
      <div class="mb-4">
        <h4 class="fw-bold mb-1">Create an Account</h4>
        <p class="text-muted mb-0">Fill in your details to get started</p>
      </div>

      <form method="POST" action="{{ route('auth.registration') }}">
        @csrf

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
              <input type="text" name="firstname" id="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}" required />

              @error('firstname')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="col-md-4">
            <label for="middlename" class="form-label">Middle Name</label>
            <input type="text" name="middlename" id="middlename" class="form-control @error('middlename') is-invalid @enderror" value="{{ old('middlename') }}" />

            @error('middlename')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="lastname" id="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname') }}" required />

            @error('lastname')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-at"></i></span>
            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required />
            @error('username')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required />

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="birthdate" class="form-label">Birthdate <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="bi bi-calendar3"></i></span>
              <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate') }}" required />

              @error('birthdate')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <label for="sex_id" class="form-label">Sex <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="bi bi-gender-ambiguous"></i></span>
              <select name="sex_id" id="sex_id" class="form-select @error('sex_id') is-invalid @enderror" required>
                <option value="" disabled {{ old('sex_id') ? '' : 'selected' }}>-- Select --</option>

                @foreach ($sexes as $sex)
                <option value="{{ $sex->id }}" {{ old('sex_id') == $sex->id ? 'selected' : '' }}>{{ ucfirst($sex->name) }}</option>
                @endforeach
              </select>

              @error('sex_id')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
        </div>

        <hr />

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required />
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3">
          <i class="bi bi-person-plus me-1"></i> Create Account
        </button>

        <p class="text-center text-muted mb-0">
          Already have an account? <a href="{{ route('auth.login') }}" class="fw-semibold text-decoration-none">Sign in</a>
        </p>
      </form>
    </div>
  </div>
</div>
@endsection