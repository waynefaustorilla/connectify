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
          <a class="nav-link active position-relative" href="{{ route('notifications.index') }}">
            <i class="bi bi-bell-fill"></i>
            @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .6rem;">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
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

      <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0">
          <i class="bi bi-bell-fill me-2"></i>Notifications
          @if($unreadCount > 0)
          <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
          @endif
        </h4>

        @if($unreadCount > 0)
        <form method="POST" action="{{ route('notifications.readAll') }}">
          @csrf
          <button type="submit" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-check2-all me-1"></i>Mark all as read
          </button>
        </form>
        @endif
      </div>

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      @forelse($notifications as $notification)
      <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="mb-2">
        @csrf
        <button type="submit" class="card shadow-sm border-0 w-100 text-start p-0 {{ !$notification->read_at ? 'border-start border-primary border-3' : '' }}" style="background: {{ !$notification->read_at ? '#f0f7ff' : '#fff' }}; cursor: pointer; border: none;">
          <div class="card-body d-flex align-items-center gap-3 py-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($notification->sender->firstname . ' ' . $notification->sender->lastname) }}&background={{ $notification->type === 'like' ? 'dc3545' : ($notification->type === 'comment' ? '0d6efd' : ($notification->type === 'follow' ? '198754' : '6f42c1')) }}&color=fff&size=48&rounded=true&bold=true" alt="{{ $notification->sender->firstname }} {{ $notification->sender->lastname }}" width="48" height="48" class="rounded-circle">

            <div class="flex-grow-1">
              <p class="mb-0">
                <span class="fw-semibold text-dark">
                  {{ $notification->sender->firstname }} {{ $notification->sender->lastname }}
                </span>

                @switch($notification->type)
                  @case('like')
                    <span class="text-muted">liked your post.</span>
                    @break
                  @case('comment')
                    <span class="text-muted">commented on your post.</span>
                    @break
                  @case('friend_request')
                    <span class="text-muted">sent you a friend request.</span>
                    @break
                  @case('friend_accepted')
                    <span class="text-muted">accepted your friend request.</span>
                    @break
                  @case('follow')
                    <span class="text-muted">started following you.</span>
                    @break
                @endswitch
              </p>
              <small class="text-muted">
                <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
              </small>
            </div>

            <div class="d-flex align-items-center gap-2">
              @switch($notification->type)
                @case('like')
                  <span class="text-danger"><i class="bi bi-heart-fill fs-5"></i></span>
                  @break
                @case('comment')
                  <span class="text-primary"><i class="bi bi-chat-fill fs-5"></i></span>
                  @break
                @case('friend_request')
                  <span><i class="bi bi-person-plus-fill fs-5" style="color: #6f42c1;"></i></span>
                  @break
                @case('friend_accepted')
                  <span><i class="bi bi-person-check-fill fs-5" style="color: #6f42c1;"></i></span>
                  @break
                @case('follow')
                  <span class="text-success"><i class="bi bi-person-heart fs-5"></i></span>
                  @break
              @endswitch

              @if(!$notification->read_at)
              <span class="badge bg-primary rounded-pill" style="font-size: .5rem;">&bull;</span>
              @endif
            </div>
          </div>
        </button>
      </form>
      @empty
      <div class="card shadow-sm border-0">
        <div class="card-body text-center text-muted py-5">
          <i class="bi bi-bell fs-1 mb-2 d-block"></i>
          <p class="mb-0">No notifications yet. Interact with others to start receiving notifications!</p>
        </div>
      </div>
      @endforelse

    </div>
  </div>
</div>

<footer class="bg-light text-muted py-3 mt-4 border-top">
  <div class="container text-center small">
    &copy; {{ date('Y') }} Connectify. All rights reserved.
  </div>
</footer>
@endsection
