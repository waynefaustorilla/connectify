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
          <a class="nav-link active" href="{{ route('home.index') }}"><i class="bi bi-house-door-fill me-1"></i>Home</a>
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
  <div class="row g-4">
    <div class="col-lg-3 d-none d-lg-block">
      <div class="card shadow-sm border-0 mb-3 overflow-hidden">
        <div class="bg-primary" style="height: 60px;"></div>
        <div class="card-body text-center" style="margin-top: -35px;">
          <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->firstname . ' ' . auth()->user()->lastname) }}&background=0d6efd&color=fff&size=70&rounded=true&bold=true" alt="avatar" width="70" height="70" class="rounded-circle border border-3 border-white shadow-sm">
          <a href="{{ route('profile.show', auth()->user()->username) }}" class="text-decoration-none">
            <h6 class="mt-2 mb-0">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h6>
          </a>
          <small class="text-muted">{{ '@' . auth()->user()->username }}</small>

          <hr>

          <div class="d-flex justify-content-around text-center">
            <div>
              <div class="fw-bold">{{ $postsCount }}</div>
              <small class="text-muted">{{ Str::plural('Post', $postsCount) }}</small>
            </div>

            <div>
              <div class="fw-bold">{{ $followersCount }}</div>
              <small class="text-muted">{{ Str::plural('Follower', $followersCount) }}</small>
            </div>

            <div>
              <div class="fw-bold">{{ $followingCount }}</div>
              <small class="text-muted">Following</small>
            </div>
          </div>
        </div>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-body p-0">
          <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-3">
              <i class="bi bi-newspaper text-primary"></i> News Feed
            </a>

            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-3">
              <i class="bi bi-people text-success"></i> Groups
            </a>

            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-3">
              <i class="bi bi-bookmark text-warning"></i> Saved Posts
            </a>

            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-3">
              <i class="bi bi-calendar-event text-info"></i> Events
            </a>

            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-3">
              <i class="bi bi-shop text-danger"></i> Marketplace
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <form method="POST" action="{{ route('posts.store') }}" class="card shadow-sm border-0 mb-4">
        @csrf
        <div class="card-body">
          <div class="d-flex gap-3 align-items-start">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->firstname . ' ' . auth()->user()->lastname) }}&background=0d6efd&color=fff&size=42&rounded=true&bold=true" alt="avatar" width="42" height="42" class="rounded-circle">
            <div class="flex-grow-1">
              <input type="text" name="title" class="form-control border-0 bg-light mb-2" placeholder="Title">
              <textarea name="content" class="form-control border-0 bg-light" rows="2" placeholder="What's on your mind, {{ auth()->user()->firstname }}?" style="resize: none;"></textarea>
            </div>
          </div>

          <hr>

          <div class="mb-3 px-2">
            <select name="category_id" class="form-select form-select-sm">
              <option value="" disabled selected>Choose a category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-around">
            <button class="btn btn-light btn-sm d-flex align-items-center gap-1">
              <i class="bi bi-image text-success"></i> Photo
            </button>

            <button class="btn btn-light btn-sm d-flex align-items-center gap-1">
              <i class="bi bi-camera-video text-danger"></i> Video
            </button>

            <button class="btn btn-light btn-sm d-flex align-items-center gap-1">
              <i class="bi bi-emoji-smile text-warning"></i> Feeling
            </button>

            <button type="submit" class="btn btn-primary btn-sm px-4">Post</button>
          </div>
        </div>
      </form>

      <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
        <div class="position-relative flex-shrink-0" style="width: 100px; height: 140px;">
          <div class="rounded-3 bg-light d-flex flex-column align-items-center justify-content-center h-100 border" style="cursor: pointer;">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mb-1" style="width: 40px; height: 40px;">
              <i class="bi bi-plus-lg text-white fs-5"></i>
            </div>
            <small class="fw-semibold">Your Story</small>
          </div>
        </div>

        @foreach(['Alice', 'Bob', 'Carol', 'Dave', 'Eve'] as $name)
        <div class="position-relative flex-shrink-0 rounded-3 overflow-hidden" style="width: 100px; height: 140px; cursor: pointer; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
          <div class="position-absolute top-0 start-0 m-2">
            <img src="https://ui-avatars.com/api/?name={{ $name }}&background=fff&color=764ba2&size=32&rounded=true&bold=true" alt="{{ $name }}" width="32" height="32" class="rounded-circle border border-2 border-primary">
          </div>

          <div class="position-absolute bottom-0 start-0 p-2">
            <small class="text-white fw-semibold" style="text-shadow: 0 1px 3px rgba(0,0,0,.5);">{{ $name }}</small>
          </div>
        </div>
        @endforeach
      </div>

      @forelse($posts as $post)
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3 mb-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->firstname . ' ' . $post->user->lastname) }}&color=fff&size=46&rounded=true&bold=true" alt="{{ $post->user->firstname }} {{ $post->user->lastname }}" width="46" height="46" class="rounded-circle">
            <div class="flex-grow-1">
              <h6 class="mb-0">{{ $post->user->firstname }} {{ $post->user->lastname }}</h6>
              <small class="text-muted">{{ '@' . $post->user->username }} &middot; {{ $post->created_at->diffForHumans() }}</small>
            </div>
            <div class="dropdown">
              <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><a class="dropdown-item" href="#"><i class="bi bi-bookmark me-2"></i>Save post</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-eye-slash me-2"></i>Hide post</a></li>
                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-flag me-2"></i>Report</a></li>
              </ul>
            </div>
          </div>

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
            <button class="btn btn-light btn-sm flex-fill me-1 d-flex align-items-center justify-content-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#comments-{{ $post->id }}">
              <i class="bi bi-chat"></i> {{ $post->comments_count }} {{ Str::plural('Comment', $post->comments_count) }}
            </button>
            <button class="btn btn-light btn-sm flex-fill d-flex align-items-center justify-content-center gap-1">
              <i class="bi bi-share"></i> Share
            </button>
          </div>

          <div class="collapse mt-3" id="comments-{{ $post->id }}">
            <form method="POST" action="{{ route('comments.store', $post) }}" class="d-flex gap-2 mb-3">
              @csrf
              <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->firstname . ' ' . auth()->user()->lastname) }}&background=0d6efd&color=fff&size=36&rounded=true&bold=true" alt="avatar" width="36" height="36" class="rounded-circle">
              <div class="flex-grow-1">
                <input type="text" name="content" class="form-control form-control-sm bg-light" placeholder="Write a comment..." required maxlength="5000">
              </div>
              <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-send"></i></button>
            </form>

            @foreach($post->comments->whereNull('parent_id') as $comment)
            <div class="d-flex gap-2 mb-2">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->firstname . ' ' . $comment->user->lastname) }}&background=6c757d&color=fff&size=32&rounded=true&bold=true" alt="{{ $comment->user->firstname }}" width="32" height="32" class="rounded-circle">
              <div class="flex-grow-1">
                <div class="bg-light rounded-3 px-3 py-2">
                  <a href="{{ route('profile.show', $comment->user->username) }}" class="fw-semibold text-decoration-none text-dark small">{{ $comment->user->firstname }} {{ $comment->user->lastname }}</a>
                  <p class="mb-0 small">{{ $comment->content }}</p>
                </div>
                <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                <button type="button" class="btn btn-link btn-sm text-muted p-0 ms-2" data-bs-toggle="collapse" data-bs-target="#reply-form-{{ $comment->id }}"><small>Reply</small></button>
                @if($comment->user_id === auth()->id())
                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-link btn-sm text-danger p-0 ms-2"><small>Delete</small></button>
                </form>
                @endif

                <div class="collapse mt-2" id="reply-form-{{ $comment->id }}">
                  <form method="POST" action="{{ route('comments.store', $post) }}" class="d-flex gap-2">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->firstname . ' ' . auth()->user()->lastname) }}&background=0d6efd&color=fff&size=28&rounded=true&bold=true" alt="avatar" width="28" height="28" class="rounded-circle">
                    <div class="flex-grow-1">
                      <input type="text" name="content" class="form-control form-control-sm bg-light" placeholder="Write a reply..." required maxlength="5000">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-send"></i></button>
                  </form>
                </div>

                @foreach($comment->replies as $reply)
                <div class="d-flex gap-2 mt-2 ms-2">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->firstname . ' ' . $reply->user->lastname) }}&background=adb5bd&color=fff&size=28&rounded=true&bold=true" alt="{{ $reply->user->firstname }}" width="28" height="28" class="rounded-circle">
                  <div class="flex-grow-1">
                    <div class="bg-light rounded-3 px-3 py-2">
                      <a href="{{ route('profile.show', $reply->user->username) }}" class="fw-semibold text-decoration-none text-dark small">{{ $reply->user->firstname }} {{ $reply->user->lastname }}</a>
                      <p class="mb-0 small">{{ $reply->content }}</p>
                    </div>
                    <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                    @if($reply->user_id === auth()->id())
                    <form method="POST" action="{{ route('comments.destroy', $reply) }}" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link btn-sm text-danger p-0 ms-2"><small>Delete</small></button>
                    </form>
                    @endif
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      @empty
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body text-center text-muted py-4">
          <i class="bi bi-chat-square-text fs-1 mb-2 d-block"></i>
          <p class="mb-0">No posts yet. Be the first to share something!</p>
        </div>
      </div>
      @endforelse

    </div>

    {{-- Right Sidebar --}}
    <div class="col-lg-3 d-none d-lg-block">

      {{-- Friend Requests --}}
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Friend Requests</h6>
          <a href="#" class="text-decoration-none small">See All</a>
        </div>
        <div class="card-body pt-0">
          @foreach(['Dave Wilson', 'Eve Santos'] as $friend)
          <div class="d-flex align-items-center gap-2 mb-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($friend) }}&background=6f42c1&color=fff&size=40&rounded=true&bold=true" alt="{{ $friend }}" width="40" height="40" class="rounded-circle">
            <div class="flex-grow-1">
              <h6 class="mb-0 small">{{ $friend }}</h6>
              <small class="text-muted">3 mutual friends</small>
            </div>
          </div>
          <div class="d-flex gap-2 mb-3">
            <button class="btn btn-primary btn-sm flex-fill">Accept</button>
            <button class="btn btn-outline-secondary btn-sm flex-fill">Decline</button>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Trending Topics --}}
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-transparent border-0">
          <h6 class="mb-0"><i class="bi bi-fire text-danger me-1"></i>Trending</h6>
        </div>
        <div class="card-body pt-0">
          @php
            $trending = [
              ['tag' => '#LaravelPHP', 'posts' => '12.4k posts'],
              ['tag' => '#WebDev', 'posts' => '8.2k posts'],
              ['tag' => '#OpenSource', 'posts' => '5.7k posts'],
              ['tag' => '#TechNews', 'posts' => '3.1k posts'],
            ];
          @endphp
          @foreach($trending as $topic)
          <div class="mb-3">
            <a href="#" class="fw-semibold text-decoration-none">{{ $topic['tag'] }}</a>
            <br><small class="text-muted">{{ $topic['posts'] }}</small>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Online Friends --}}
      <div class="card shadow-sm border-0">
        <div class="card-header bg-transparent border-0">
          <h6 class="mb-0">Online Friends</h6>
        </div>
        <div class="card-body pt-0">
          @foreach(['Frank Lee', 'Grace Kim', 'Henry Park', 'Ivy Chen'] as $online)
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="position-relative">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($online) }}&background=198754&color=fff&size=34&rounded=true&bold=true" alt="{{ $online }}" width="34" height="34" class="rounded-circle">
              <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width: 10px; height: 10px;"></span>
            </div>
            <span class="small">{{ $online }}</span>
          </div>
          @endforeach
        </div>
      </div>

    </div>

  </div>
</div>

{{-- Footer --}}
<footer class="bg-light text-muted py-3 mt-4 border-top">
  <div class="container text-center small">
    &copy; {{ date('Y') }} Connectify. All rights reserved.
  </div>
</footer>
@endsection