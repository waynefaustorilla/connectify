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
          <input class="form-control border-start-0" type="search" name="q" value="{{ $query }}" placeholder="Search people, posts..." aria-label="Search">
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

      <h4 class="fw-bold mb-4">
        <i class="bi bi-search me-2"></i>Search Results
        @if($query)
          <span class="text-muted fw-normal fs-6">for "{{ $query }}"</span>
        @endif
      </h4>

      @if(!$query)
        <div class="card shadow-sm border-0">
          <div class="card-body text-center text-muted py-5">
            <i class="bi bi-search fs-1 mb-2 d-block"></i>
            <p class="mb-0">Enter a search term to find people and posts.</p>
          </div>
        </div>
      @else
        @if($users->isNotEmpty())
        <h6 class="text-muted text-uppercase small fw-bold mb-3">
          <i class="bi bi-people me-1"></i>People ({{ $users->count() }})
        </h6>

        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body p-0">
            @foreach($users as $user)
            <a href="{{ route('profile.show', $user->username) }}" class="d-flex align-items-center gap-3 p-3 text-decoration-none text-dark border-bottom">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($user->firstname . ' ' . $user->lastname) }}&background=0d6efd&color=fff&size=48&rounded=true&bold=true" alt="{{ $user->firstname }} {{ $user->lastname }}" width="48" height="48" class="rounded-circle">
              <div>
                <h6 class="mb-0">{{ $user->firstname }} {{ $user->lastname }}</h6>
                <small class="text-muted">{{ '@' . $user->username }}</small>
              </div>
            </a>
            @endforeach
          </div>
        </div>
        @endif

        @if($posts->isNotEmpty())
        <h6 class="text-muted text-uppercase small fw-bold mb-3">
          <i class="bi bi-file-text me-1"></i>Posts ({{ $posts->count() }})
        </h6>

        @foreach($posts as $post)
        <div class="card shadow-sm border-0 mb-3">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->firstname . ' ' . $post->user->lastname) }}&color=fff&size=46&rounded=true&bold=true" alt="{{ $post->user->firstname }} {{ $post->user->lastname }}" width="46" height="46" class="rounded-circle">
              <div class="flex-grow-1">
                <h6 class="mb-0">
                  <a href="{{ route('profile.show', $post->user->username) }}" class="text-decoration-none text-dark">{{ $post->user->firstname }} {{ $post->user->lastname }}</a>
                </h6>

                <small class="text-muted">{{ '@' . $post->user->username }} &middot; {{ $post->created_at->diffForHumans() }}</small>
              </div>
            </div>

            @if($post->category)
            <span class="badge bg-primary bg-opacity-10 text-primary mb-2">{{ ucfirst($post->category->name) }}</span>
            @endif

            <h6 class="mb-2">{{ $post->title }}</h6>
            <p class="mb-3" style="line-height: 1.6;">{{ $post->content }}</p>

            <div class="d-flex justify-content-around border-top pt-2">
              <form method="POST" action="{{ route('posts.like', $post) }}" class="flex-fill me-1">
                @csrf
                <button type="submit" class="btn btn-light btn-sm w-100 d-flex align-items-center justify-content-center gap-1 {{ $post->likes->contains('user_id', auth()->id()) ? 'text-danger' : '' }}">
                  <i class="bi {{ $post->likes->contains('user_id', auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                  {{ $post->likes_count }} {{ Str::plural('Like', $post->likes_count) }}
                </button>
              </form>
              <button class="btn btn-light btn-sm flex-fill me-1 d-flex align-items-center justify-content-center gap-1">
                <i class="bi bi-chat"></i> Comment
              </button>
              <button class="btn btn-light btn-sm flex-fill d-flex align-items-center justify-content-center gap-1">
                <i class="bi bi-share"></i> Share
              </button>
            </div>
          </div>
        </div>
        @endforeach
        @endif

        {{-- No Results --}}
        @if($users->isEmpty() && $posts->isEmpty())
        <div class="card shadow-sm border-0">
          <div class="card-body text-center text-muted py-5">
            <i class="bi bi-emoji-frown fs-1 mb-2 d-block"></i>
            <p class="mb-0">No results found for "{{ $query }}". Try a different search term.</p>
          </div>
        </div>
        @endif

      @endif

    </div>
  </div>
</div>

<footer class="bg-light text-muted py-3 mt-4 border-top">
  <div class="container text-center small">
    &copy; {{ date('Y') }} Connectify. All rights reserved.
  </div>
</footer>
@endsection
