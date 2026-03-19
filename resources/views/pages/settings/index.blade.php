@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home.index') }}">
      <i class="bi bi-chat-square-heart-fill me-2"></i>Connectify
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <form class="d-flex mx-auto my-2 my-lg-0" style="max-width: 420px; width: 100%;" role="search" action="{{ route('search') }}" method="GET">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
          <input class="form-control border-start-0" type="search" name="q" placeholder="Search people, posts..." aria-label="Search">
        </div>
      </form>

      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home.index') }}"><i class="bi bi-house-door-fill me-1"></i>Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('friends.index') }}"><i class="bi bi-people-fill me-1"></i>Friends</a>
        </li>

        <li class="nav-item">
          <a class="nav-link position-relative" href="{{ route('notifications.index') }}">
            <i class="bi bi-bell-fill"></i>
            @if($notificationUnreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .6rem;">{{ $notificationUnreadCount > 99 ? '99+' : $notificationUnreadCount }}</span>
            @endif
          </a>
        </li>

        <li class="nav-item dropdown ms-2">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->firstname . ' ' . Auth::user()->lastname) }}&background=fff&color=0d6efd&size=32&rounded=true&bold=true" alt="avatar" width="32" height="32" class="rounded-circle">
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item" href="{{ route('profile.show', Auth::user()->username) }}"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-gear fs-4 text-primary"></i>
        <h4 class="fw-bold mb-0">Settings</h4>
      </div>

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      {{-- Profile Information --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <h5 class="fw-semibold mb-1"><i class="bi bi-person-circle me-2 text-primary"></i>Profile Information</h5>
          <p class="text-muted small mb-0">Update your personal details and contact information.</p>
        </div>

        <div class="card-body px-4 pb-4">
          <form method="POST" action="{{ route('settings.profile') }}">
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <div class="col-md-4">
                <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" name="firstname" id="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname', Auth::user()->firstname) }}" required />
                @error('firstname')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>

              <div class="col-md-4">
                <label for="middlename" class="form-label">Middle Name</label>
                <input type="text" name="middlename" id="middlename" class="form-control @error('middlename') is-invalid @enderror" value="{{ old('middlename', Auth::user()->middlename) }}" />
                @error('middlename')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>

              <div class="col-md-4">
                <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" name="lastname" id="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname', Auth::user()->lastname) }}" required />
                @error('lastname')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-at"></i></span>
                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', Auth::user()->username) }}" required />
                @error('username')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required />
                @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="birthdate" class="form-label">Birthdate <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-calendar3"></i></span>
                  <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate', Auth::user()->birthdate) }}" required />
                  @error('birthdate')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <label for="sex_id" class="form-label">Sex <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-gender-ambiguous"></i></span>
                  <select name="sex_id" id="sex_id" class="form-select @error('sex_id') is-invalid @enderror" required>
                    @foreach ($sexes as $sex)
                    <option value="{{ $sex->id }}" {{ old('sex_id', Auth::user()->sex_id) == $sex->id ? 'selected' : '' }}>{{ ucfirst($sex->name) }}</option>
                    @endforeach
                  </select>
                  @error('sex_id')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary fw-semibold px-4">
                <i class="bi bi-check-lg me-1"></i>Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- About Me --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <h5 class="fw-semibold mb-1"><i class="bi bi-info-circle me-2 text-primary"></i>About Me</h5>
          <p class="text-muted small mb-0">Tell others more about yourself.</p>
        </div>

        <div class="card-body px-4 pb-4">
          <form method="POST" action="{{ route('settings.about') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="bio" class="form-label">Bio</label>
              <textarea name="bio" id="bio" rows="3" class="form-control @error('bio') is-invalid @enderror" maxlength="1000" placeholder="Write a short bio about yourself...">{{ old('bio', $userProfile->bio ?? '') }}</textarea>
              @error('bio')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="hometown" class="form-label">Hometown</label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                  <input type="text" name="hometown" id="hometown" class="form-control @error('hometown') is-invalid @enderror" value="{{ old('hometown', $userProfile->hometown ?? '') }}" placeholder="Where are you from?" />
                  @error('hometown')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <label for="current_city" class="form-label">Current City</label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                  <input type="text" name="current_city" id="current_city" class="form-control @error('current_city') is-invalid @enderror" value="{{ old('current_city', $userProfile->current_city ?? '') }}" placeholder="Where do you live now?" />
                  @error('current_city')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="website" class="form-label">Website</label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-globe"></i></span>
                  <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $userProfile->website ?? '') }}" placeholder="https://example.com" />
                  @error('website')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <label for="relationship_status_id" class="form-label">Relationship Status</label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-heart"></i></span>
                  <select name="relationship_status_id" id="relationship_status_id" class="form-select @error('relationship_status_id') is-invalid @enderror">
                    <option value="">-- Select --</option>
                    @foreach ($relationshipStatuses as $status)
                    <option value="{{ $status->id }}" {{ old('relationship_status_id', $userProfile->relationship_status_id ?? '') == $status->id ? 'selected' : '' }}>{{ ucfirst($status->name) }}</option>
                    @endforeach
                  </select>
                  @error('relationship_status_id')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary fw-semibold px-4">
                <i class="bi bi-check-lg me-1"></i>Save About
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- Work Experience --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <h5 class="fw-semibold mb-1"><i class="bi bi-briefcase me-2 text-primary"></i>Work Experience</h5>
          <p class="text-muted small mb-0">Add your professional work history.</p>
        </div>

        <div class="card-body px-4 pb-4">
          @foreach ($workExperiences as $work)
          <div class="border rounded-3 p-3 mb-3 bg-light">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <h6 class="fw-semibold mb-0">{{ $work->job_title }}</h6>
                <small class="text-muted">{{ $work->company_name }}@if($work->employmentType) &middot; {{ ucfirst($work->employmentType->name) }}@endif</small><br>
                <small class="text-muted">{{ $work->start_date->format('M Y') }} &mdash; {{ $work->is_current ? 'Present' : ($work->end_date ? $work->end_date->format('M Y') : '') }}</small>
              </div>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-work-{{ $work->id }}"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('settings.work-experiences.destroy', $work->id) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </div>
            @if($work->description)
            <p class="small mb-0">{{ $work->description }}</p>
            @endif

            <div class="collapse mt-3" id="edit-work-{{ $work->id }}">
              <form method="POST" action="{{ route('settings.work-experiences.update', $work->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-2">
                  <div class="col-md-6">
                    <input type="text" name="company_name" class="form-control form-control-sm" value="{{ $work->company_name }}" placeholder="Company" required />
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="job_title" class="form-control form-control-sm" value="{{ $work->job_title }}" placeholder="Job Title" required />
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-md-4">
                    <select name="employment_type_id" class="form-select form-select-sm">
                      <option value="">-- Type --</option>
                      @foreach ($employmentTypes as $type)
                      <option value="{{ $type->id }}" {{ $work->employment_type_id == $type->id ? 'selected' : '' }}>{{ ucfirst($type->name) }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $work->start_date->format('Y-m-d') }}" required />
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $work->end_date?->format('Y-m-d') }}" />
                  </div>
                  <div class="col-md-2 d-flex align-items-center">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="is_current" value="1" id="is_current_{{ $work->id }}" {{ $work->is_current ? 'checked' : '' }}>
                      <label class="form-check-label small" for="is_current_{{ $work->id }}">Current</label>
                    </div>
                  </div>
                </div>
                <div class="mb-2">
                  <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Description">{{ $work->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
              </form>
            </div>
          </div>
          @endforeach

          <button class="btn btn-outline-primary btn-sm mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#add-work">
            <i class="bi bi-plus-lg me-1"></i>Add Work Experience
          </button>

          <div class="collapse" id="add-work">
            <form method="POST" action="{{ route('settings.work-experiences.store') }}" class="border rounded-3 p-3">
              @csrf
              <div class="row mb-2">
                <div class="col-md-6">
                  <label class="form-label small">Company <span class="text-danger">*</span></label>
                  <input type="text" name="company_name" class="form-control form-control-sm @error('company_name') is-invalid @enderror" placeholder="Company name" required />
                  @error('company_name')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label small">Job Title <span class="text-danger">*</span></label>
                  <input type="text" name="job_title" class="form-control form-control-sm @error('job_title') is-invalid @enderror" placeholder="Your role" required />
                  @error('job_title')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-4">
                  <label class="form-label small">Employment Type</label>
                  <select name="employment_type_id" class="form-select form-select-sm">
                    <option value="">-- Select --</option>
                    @foreach ($employmentTypes as $type)
                    <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                  <input type="date" name="start_date" class="form-control form-control-sm @error('start_date') is-invalid @enderror" required />
                  @error('start_date')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
                <div class="col-md-3">
                  <label class="form-label small">End Date</label>
                  <input type="date" name="end_date" class="form-control form-control-sm" />
                </div>
                <div class="col-md-2 d-flex align-items-end pb-1">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_current" value="1" id="is_current_new">
                    <label class="form-check-label small" for="is_current_new">Current</label>
                  </div>
                </div>
              </div>
              <div class="mb-2">
                <label class="form-label small">Description</label>
                <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="What did you do?"></textarea>
              </div>
              <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Add</button>
            </form>
          </div>
        </div>
      </div>

      {{-- Academic Experience --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <h5 class="fw-semibold mb-1"><i class="bi bi-mortarboard me-2 text-primary"></i>Academic Experience</h5>
          <p class="text-muted small mb-0">Add your educational background.</p>
        </div>

        <div class="card-body px-4 pb-4">
          @foreach ($academicExperiences as $edu)
          <div class="border rounded-3 p-3 mb-3 bg-light">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <h6 class="fw-semibold mb-0">{{ $edu->school_name }}</h6>
                <small class="text-muted">@if($edu->educationLevel){{ ucfirst($edu->educationLevel->name) }}@endif @if($edu->field_of_study) in {{ $edu->field_of_study }}@endif</small><br>
                <small class="text-muted">{{ $edu->start_year }} &mdash; {{ $edu->end_year ?? 'Present' }}</small>
              </div>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-edu-{{ $edu->id }}"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('settings.academic-experiences.destroy', $edu->id) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </div>
            @if($edu->description)
            <p class="small mb-0">{{ $edu->description }}</p>
            @endif

            <div class="collapse mt-3" id="edit-edu-{{ $edu->id }}">
              <form method="POST" action="{{ route('settings.academic-experiences.update', $edu->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-2">
                  <div class="col-md-6">
                    <input type="text" name="school_name" class="form-control form-control-sm" value="{{ $edu->school_name }}" placeholder="School name" required />
                  </div>
                  <div class="col-md-6">
                    <select name="education_level_id" class="form-select form-select-sm">
                      <option value="">-- Level --</option>
                      @foreach ($educationLevels as $level)
                      <option value="{{ $level->id }}" {{ $edu->education_level_id == $level->id ? 'selected' : '' }}>{{ ucfirst($level->name) }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-md-4">
                    <input type="text" name="field_of_study" class="form-control form-control-sm" value="{{ $edu->field_of_study }}" placeholder="Field of study" />
                  </div>
                  <div class="col-md-4">
                    <input type="number" name="start_year" class="form-control form-control-sm" value="{{ $edu->start_year }}" placeholder="Start year" min="1900" required />
                  </div>
                  <div class="col-md-4">
                    <input type="number" name="end_year" class="form-control form-control-sm" value="{{ $edu->end_year }}" placeholder="End year" min="1900" />
                  </div>
                </div>
                <div class="mb-2">
                  <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Description">{{ $edu->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
              </form>
            </div>
          </div>
          @endforeach

          <button class="btn btn-outline-primary btn-sm mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#add-edu">
            <i class="bi bi-plus-lg me-1"></i>Add Academic Experience
          </button>

          <div class="collapse" id="add-edu">
            <form method="POST" action="{{ route('settings.academic-experiences.store') }}" class="border rounded-3 p-3">
              @csrf
              <div class="row mb-2">
                <div class="col-md-6">
                  <label class="form-label small">School Name <span class="text-danger">*</span></label>
                  <input type="text" name="school_name" class="form-control form-control-sm @error('school_name') is-invalid @enderror" placeholder="University or school" required />
                  @error('school_name')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label small">Education Level</label>
                  <select name="education_level_id" class="form-select form-select-sm">
                    <option value="">-- Select --</option>
                    @foreach ($educationLevels as $level)
                    <option value="{{ $level->id }}">{{ ucfirst($level->name) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-4">
                  <label class="form-label small">Field of Study</label>
                  <input type="text" name="field_of_study" class="form-control form-control-sm" placeholder="e.g., Computer Science" />
                </div>
                <div class="col-md-4">
                  <label class="form-label small">Start Year <span class="text-danger">*</span></label>
                  <input type="number" name="start_year" class="form-control form-control-sm @error('start_year') is-invalid @enderror" placeholder="2020" min="1900" required />
                  @error('start_year')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
                <div class="col-md-4">
                  <label class="form-label small">End Year</label>
                  <input type="number" name="end_year" class="form-control form-control-sm" placeholder="2024" min="1900" />
                </div>
              </div>
              <div class="mb-2">
                <label class="form-label small">Description</label>
                <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Activities, honors, etc."></textarea>
              </div>
              <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Add</button>
            </form>
          </div>
        </div>
      </div>

      {{-- Dating History --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <h5 class="fw-semibold mb-1"><i class="bi bi-heart me-2 text-primary"></i>Dating History</h5>
          <p class="text-muted small mb-0">Optionally share your past relationships.</p>
        </div>

        <div class="card-body px-4 pb-4">
          @foreach ($datingHistories as $dating)
          <div class="border rounded-3 p-3 mb-3 bg-light">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <h6 class="fw-semibold mb-0">{{ $dating->partner_name }}</h6>
                <small class="text-muted">{{ $dating->start_date ? $dating->start_date->format('M Y') : '' }} @if($dating->start_date)&mdash;@endif {{ $dating->end_date ? $dating->end_date->format('M Y') : '' }}</small>
              </div>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-dating-{{ $dating->id }}"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('settings.dating-histories.destroy', $dating->id) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </div>
            @if($dating->description)
            <p class="small mb-0">{{ $dating->description }}</p>
            @endif

            <div class="collapse mt-3" id="edit-dating-{{ $dating->id }}">
              <form method="POST" action="{{ route('settings.dating-histories.update', $dating->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-2">
                  <div class="col-md-4">
                    <input type="text" name="partner_name" class="form-control form-control-sm" value="{{ $dating->partner_name }}" placeholder="Partner name" required />
                  </div>
                  <div class="col-md-4">
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $dating->start_date?->format('Y-m-d') }}" />
                  </div>
                  <div class="col-md-4">
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $dating->end_date?->format('Y-m-d') }}" />
                  </div>
                </div>
                <div class="mb-2">
                  <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Description">{{ $dating->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
              </form>
            </div>
          </div>
          @endforeach

          <button class="btn btn-outline-primary btn-sm mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#add-dating">
            <i class="bi bi-plus-lg me-1"></i>Add Dating History
          </button>

          <div class="collapse" id="add-dating">
            <form method="POST" action="{{ route('settings.dating-histories.store') }}" class="border rounded-3 p-3">
              @csrf
              <div class="row mb-2">
                <div class="col-md-4">
                  <label class="form-label small">Partner Name <span class="text-danger">*</span></label>
                  <input type="text" name="partner_name" class="form-control form-control-sm @error('partner_name') is-invalid @enderror" placeholder="Name" required />
                  @error('partner_name')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
                <div class="col-md-4">
                  <label class="form-label small">Start Date</label>
                  <input type="date" name="start_date" class="form-control form-control-sm" />
                </div>
                <div class="col-md-4">
                  <label class="form-label small">End Date</label>
                  <input type="date" name="end_date" class="form-control form-control-sm" />
                </div>
              </div>
              <div class="mb-2">
                <label class="form-label small">Description</label>
                <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="Any details..."></textarea>
              </div>
              <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Add</button>
            </form>
          </div>
        </div>
      </div>

      {{-- Change Password --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <h5 class="fw-semibold mb-1"><i class="bi bi-shield-lock me-2 text-primary"></i>Change Password</h5>
          <p class="text-muted small mb-0">Ensure your account uses a strong, secure password.</p>
        </div>

        <div class="card-body px-4 pb-4">
          <form method="POST" action="{{ route('settings.password') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required />
                @error('current_password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required />
                  @error('password')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary fw-semibold px-4">
                <i class="bi bi-shield-check me-1"></i>Update Password
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- Privacy Settings --}}
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <h5 class="fw-semibold mb-1"><i class="bi bi-eye-slash me-2 text-primary"></i>Privacy</h5>
          <p class="text-muted small mb-0">Control who can see your posts and interact with you.</p>
        </div>

        <div class="card-body px-4 pb-4">
          <form method="POST" action="{{ route('settings.privacy') }}">
            @csrf
            @method('PUT')

            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" role="switch" name="is_private" id="is_private" value="1" {{ $isPrivate ? 'checked' : '' }}>
              <label class="form-check-label" for="is_private">
                <strong>Private Account</strong>
              </label>
              <p class="text-muted small mb-0 mt-1">When enabled, only friends can see your posts and interact with you. Your profile will still be visible in search results.</p>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary fw-semibold px-4">
                <i class="bi bi-check-lg me-1"></i>Save Privacy
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
