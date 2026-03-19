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
          <a class="nav-link active" href="{{ route('friends.index') }}"><i class="bi bi-people-fill me-1"></i>Friends</a>
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

      <h4 class="fw-bold mb-4">
        <i class="bi bi-people-fill me-2"></i>Friends
      </h4>

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      {{-- Tabs --}}
      <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="friends-tab" data-bs-toggle="tab" data-bs-target="#friends-pane" type="button" role="tab">
            <i class="bi bi-people me-1"></i>Friends
            <span class="badge bg-primary ms-1">{{ $friends->count() }}</span>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests-pane" type="button" role="tab">
            <i class="bi bi-person-plus me-1"></i>Requests
            @if($receivedRequests->count() > 0)
            <span class="badge bg-danger ms-1">{{ $receivedRequests->count() }}</span>
            @endif
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent-pane" type="button" role="tab">
            <i class="bi bi-send me-1"></i>Sent
            @if($sentRequests->count() > 0)
            <span class="badge bg-secondary ms-1">{{ $sentRequests->count() }}</span>
            @endif
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers-pane" type="button" role="tab">
            <i class="bi bi-person-heart me-1"></i>Followers
            <span class="badge bg-info ms-1">{{ $followers->count() }}</span>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="following-tab" data-bs-toggle="tab" data-bs-target="#following-pane" type="button" role="tab">
            <i class="bi bi-person-check me-1"></i>Following
            <span class="badge bg-success ms-1">{{ $following->count() }}</span>
          </button>
        </li>
      </ul>

      {{-- Tab Content --}}
      <div class="tab-content">

        {{-- Friends List --}}
        <div class="tab-pane fade show active" id="friends-pane" role="tabpanel">
          @forelse($friends as $friend)
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center gap-3">
              <a href="{{ route('profile.show', $friend->username) }}">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($friend->firstname . ' ' . $friend->lastname) }}&background=0d6efd&color=fff&size=56&rounded=true&bold=true" alt="{{ $friend->firstname }} {{ $friend->lastname }}" width="56" height="56" class="rounded-circle">
              </a>

              <div class="flex-grow-1">
                <h6 class="mb-0">
                  <a href="{{ route('profile.show', $friend->username) }}" class="text-decoration-none text-dark">
                    {{ $friend->firstname }} {{ $friend->lastname }}
                  </a>
                </h6>
                <small class="text-muted">{{ '@' . $friend->username }}</small>
              </div>

              <div class="d-flex gap-2">
                <a href="{{ route('profile.show', $friend->username) }}" class="btn btn-outline-primary btn-sm">
                  <i class="bi bi-person me-1"></i>Profile
                </a>
                <form method="POST" action="{{ route('friends.unfriend', $friend->id) }}">
                  @csrf
                  <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-person-dash me-1"></i>Unfriend
                  </button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
              <i class="bi bi-people fs-1 mb-2 d-block"></i>
              <p class="mb-0">You don't have any friends yet. Search for people and send them a friend request!</p>
            </div>
          </div>
          @endforelse
        </div>

        {{-- Received Requests --}}
        <div class="tab-pane fade" id="requests-pane" role="tabpanel">
          @forelse($receivedRequests as $user)
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center gap-3">
              <a href="{{ route('profile.show', $user->username) }}">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->firstname . ' ' . $user->lastname) }}&background=6f42c1&color=fff&size=56&rounded=true&bold=true" alt="{{ $user->firstname }} {{ $user->lastname }}" width="56" height="56" class="rounded-circle">
              </a>

              <div class="flex-grow-1">
                <h6 class="mb-0">
                  <a href="{{ route('profile.show', $user->username) }}" class="text-decoration-none text-dark">
                    {{ $user->firstname }} {{ $user->lastname }}
                  </a>
                </h6>
                <small class="text-muted">{{ '@' . $user->username }}</small>
              </div>

              <div class="d-flex gap-2">
                <form method="POST" action="{{ route('friends.accept', $user->id) }}">
                  @csrf
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check-lg me-1"></i>Accept
                  </button>
                </form>
                <form method="POST" action="{{ route('friends.decline', $user->id) }}">
                  @csrf
                  <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg me-1"></i>Decline
                  </button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
              <i class="bi bi-person-plus fs-1 mb-2 d-block"></i>
              <p class="mb-0">No pending friend requests.</p>
            </div>
          </div>
          @endforelse
        </div>

        {{-- Sent Requests --}}
        <div class="tab-pane fade" id="sent-pane" role="tabpanel">
          @forelse($sentRequests as $user)
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center gap-3">
              <a href="{{ route('profile.show', $user->username) }}">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->firstname . ' ' . $user->lastname) }}&background=198754&color=fff&size=56&rounded=true&bold=true" alt="{{ $user->firstname }} {{ $user->lastname }}" width="56" height="56" class="rounded-circle">
              </a>

              <div class="flex-grow-1">
                <h6 class="mb-0">
                  <a href="{{ route('profile.show', $user->username) }}" class="text-decoration-none text-dark">
                    {{ $user->firstname }} {{ $user->lastname }}
                  </a>
                </h6>
                <small class="text-muted">{{ '@' . $user->username }}</small>
              </div>

              <div>
                <form method="POST" action="{{ route('friends.cancel', $user->id) }}">
                  @csrf
                  <button type="submit" class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-x-circle me-1"></i>Cancel Request
                  </button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
              <i class="bi bi-send fs-1 mb-2 d-block"></i>
              <p class="mb-0">You haven't sent any friend requests.</p>
            </div>
          </div>
          @endforelse
        </div>

        {{-- Followers --}}
        <div class="tab-pane fade" id="followers-pane" role="tabpanel">
          @forelse($followers as $user)
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center gap-3">
              <a href="{{ route('profile.show', $user->username) }}">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->firstname . ' ' . $user->lastname) }}&background=0dcaf0&color=fff&size=56&rounded=true&bold=true" alt="{{ $user->firstname }} {{ $user->lastname }}" width="56" height="56" class="rounded-circle">
              </a>

              <div class="flex-grow-1">
                <h6 class="mb-0">
                  <a href="{{ route('profile.show', $user->username) }}" class="text-decoration-none text-dark">
                    {{ $user->firstname }} {{ $user->lastname }}
                  </a>
                </h6>
                <small class="text-muted">{{ '@' . $user->username }}</small>
              </div>

              <a href="{{ route('profile.show', $user->username) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-person me-1"></i>Profile
              </a>
            </div>
          </div>
          @empty
          <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
              <i class="bi bi-person-heart fs-1 mb-2 d-block"></i>
              <p class="mb-0">You don't have any followers yet.</p>
            </div>
          </div>
          @endforelse
        </div>

        {{-- Following --}}
        <div class="tab-pane fade" id="following-pane" role="tabpanel">
          @forelse($following as $user)
          <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center gap-3">
              <a href="{{ route('profile.show', $user->username) }}">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->firstname . ' ' . $user->lastname) }}&background=198754&color=fff&size=56&rounded=true&bold=true" alt="{{ $user->firstname }} {{ $user->lastname }}" width="56" height="56" class="rounded-circle">
              </a>

              <div class="flex-grow-1">
                <h6 class="mb-0">
                  <a href="{{ route('profile.show', $user->username) }}" class="text-decoration-none text-dark">
                    {{ $user->firstname }} {{ $user->lastname }}
                  </a>
                </h6>
                <small class="text-muted">{{ '@' . $user->username }}</small>
              </div>

              <form method="POST" action="{{ route('follow.toggle', $user->id) }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                  <i class="bi bi-person-dash me-1"></i>Unfollow
                </button>
              </form>
            </div>
          </div>
          @empty
          <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
              <i class="bi bi-person-check fs-1 mb-2 d-block"></i>
              <p class="mb-0">You're not following anyone yet.</p>
            </div>
          </div>
          @endforelse
        </div>

      </div>
    </div>
  </div>
</div>

<footer class="bg-light text-muted py-3 mt-4 border-top">
  <div class="container text-center small">
    &copy; {{ date('Y') }} Connectify. All rights reserved.
  </div>
</footer>
@endsection
