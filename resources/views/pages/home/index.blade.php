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
      <form class="d-flex mx-auto my-2 my-lg-0" style="max-width: 420px; width: 100%;" role="search">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
          <input class="form-control border-start-0" type="search" placeholder="Search people, posts..." aria-label="Search">
        </div>
      </form>

      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('home.index') }}"><i class="bi bi-house-door-fill me-1"></i>Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-people-fill me-1"></i>Friends</a>
        </li>

        <li class="nav-item">
          <a class="nav-link position-relative" href="#">
            <i class="bi bi-bell-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .6rem;">3</span>
          </a>
        </li>

        <li class="nav-item dropdown ms-2">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name=John+Doe&background=fff&color=0d6efd&size=32&rounded=true&bold=true" alt="avatar" width="32" height="32" class="rounded-circle">
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
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
          <img src="https://ui-avatars.com/api/?name=John+Doe&background=0d6efd&color=fff&size=70&rounded=true&bold=true" alt="avatar" width="70" height="70" class="rounded-circle border border-3 border-white shadow-sm">
          <h6 class="mt-2 mb-0">John Doe</h6>
          <small class="text-muted">@johndoe</small>

          <hr>

          <div class="d-flex justify-content-around text-center">
            <div>
              <div class="fw-bold">128</div>
              <small class="text-muted">Posts</small>
            </div>

            <div>
              <div class="fw-bold">1.2k</div>
              <small class="text-muted">Followers</small>
            </div>

            <div>
              <div class="fw-bold">384</div>
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
            <img src="https://ui-avatars.com/api/?name=John+Doe&background=0d6efd&color=fff&size=42&rounded=true&bold=true" alt="avatar" width="42" height="42" class="rounded-circle">
            <div class="flex-grow-1">
              <input type="text" name="title" class="form-control border-0 bg-light mb-2" placeholder="Title">
              <textarea name="content" class="form-control border-0 bg-light" rows="2" placeholder="What's on your mind, John?" style="resize: none;"></textarea>
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

      @php
        $posts = [
          [
            'name' => 'Alice Johnson',
            'handle' => '@alicej',
            'time' => '2 hours ago',
            'content' => "Just finished building my first Laravel app! \xF0\x9F\x9A\x80 The Eloquent ORM makes working with databases so elegant. Can't wait to share it with you all!",
            'likes' => 42,
            'comments' => 8,
            'shares' => 3,
            'color' => 'e91e63',
          ],
          [
            'name' => 'Bob Martinez',
            'handle' => '@bobm',
            'time' => '4 hours ago',
            'content' => "Beautiful sunset at the beach today \xF0\x9F\x8C\x85 Sometimes you just need to unplug and enjoy nature. Who else loves weekend getaways?",
            'likes' => 127,
            'comments' => 24,
            'shares' => 11,
            'color' => 'ff9800',
          ],
          [
            'name' => 'Carol Williams',
            'handle' => '@carolw',
            'time' => '6 hours ago',
            'content' => "Hot take: Tailwind CSS is great, but there's something satisfying about writing clean Bootstrap components. What's your go-to CSS framework? \xF0\x9F\x8E\xA8",
            'likes' => 89,
            'comments' => 45,
            'shares' => 7,
            'color' => '9c27b0',
          ],
        ];
      @endphp

      @foreach($posts as $post)
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3 mb-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($post['name']) }}&background={{ $post['color'] }}&color=fff&size=46&rounded=true&bold=true" alt="{{ $post['name'] }}" width="46" height="46" class="rounded-circle">
            <div class="flex-grow-1">
              <h6 class="mb-0">{{ $post['name'] }}</h6>
              <small class="text-muted">{{ $post['handle'] }} &middot; {{ $post['time'] }}</small>
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

          <p class="mb-3" style="line-height: 1.6;">{{ $post['content'] }}</p>
          <div class="d-flex justify-content-between text-muted small border-top border-bottom py-2 mb-2">
            <span><i class="bi bi-heart-fill text-danger me-1"></i>{{ $post['likes'] }} likes</span>
            <span>{{ $post['comments'] }} comments &middot; {{ $post['shares'] }} shares</span>
          </div>
          <div class="d-flex justify-content-around">
            <button class="btn btn-light btn-sm flex-fill me-1 d-flex align-items-center justify-content-center gap-1">
              <i class="bi bi-heart"></i> Like
            </button>
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