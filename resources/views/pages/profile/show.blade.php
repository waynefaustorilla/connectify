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

<div class="position-relative">
  <div style="height: 280px; background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);"></div>

  <div class="container" style="margin-top: -80px;">
    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end gap-3 px-3">
      <a href="{{ route('profile.show', $profileUser->username) }}">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($profileUser->firstname . ' ' . $profileUser->lastname) }}&background=0d6efd&color=fff&size=150&rounded=true&bold=true" alt="{{ $profileUser->firstname }} {{ $profileUser->lastname }}" width="150" height="150" class="rounded-circle border border-4 border-white shadow">
      </a>

      <div class="flex-grow-1 text-center text-md-start mb-3">
        <h3 class="fw-bold mb-0 text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,.3);">
          {{ $profileUser->firstname }} {{ $profileUser->middlename ? $profileUser->middlename . ' ' : '' }}{{ $profileUser->lastname }}
        </h3>

        <p class="text-white-50 mb-0" style="text-shadow: 0 1px 2px rgba(0,0,0,.3);">{{ '@' . $profileUser->username }}@if($isPrivate) <i class="bi bi-lock-fill" title="Private Account"></i>@endif</p>
      </div>

      <div class="mb-3 d-flex gap-2">
        @if(Auth::id() === $profileUser->id)
          <a href="{{ route('settings.index') }}" class="btn btn-light fw-semibold">
            <i class="bi bi-pencil me-1"></i> Edit Profile
          </a>
        @else
          @if($friendshipStatus && $friendshipStatus['status'] === 'accepted')
            <form method="POST" action="{{ route('friends.unfriend', $profileUser->id) }}">
              @csrf
              <button type="submit" class="btn btn-outline-danger fw-semibold">
                <i class="bi bi-person-dash me-1"></i> Unfriend
              </button>
            </form>
          @elseif($friendshipStatus && $friendshipStatus['status'] === 'pending' && $friendshipStatus['is_sender'])
            <form method="POST" action="{{ route('friends.cancel', $profileUser->id) }}">
              @csrf
              <button type="submit" class="btn btn-outline-warning fw-semibold">
                <i class="bi bi-x-circle me-1"></i> Cancel Request
              </button>
            </form>
          @elseif($friendshipStatus && $friendshipStatus['status'] === 'pending' && !$friendshipStatus['is_sender'])
            <div class="d-flex gap-2">
              <form method="POST" action="{{ route('friends.accept', $profileUser->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary fw-semibold">
                  <i class="bi bi-check-lg me-1"></i> Accept
                </button>
              </form>
              <form method="POST" action="{{ route('friends.decline', $profileUser->id) }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary fw-semibold">
                  <i class="bi bi-x-lg me-1"></i> Decline
                </button>
              </form>
            </div>
          @else
            <form method="POST" action="{{ route('friends.send', $profileUser->id) }}">
              @csrf
              <button type="submit" class="btn btn-primary fw-semibold">
                <i class="bi bi-person-plus me-1"></i> Add Friend
              </button>
            </form>
          @endif

          <form method="POST" action="{{ route('follow.toggle', $profileUser->id) }}">
            @csrf
            @if($isFollowing)
              <button type="submit" class="btn btn-outline-secondary fw-semibold">
                <i class="bi bi-person-check me-1"></i> Following
              </button>
            @else
              <button type="submit" class="btn btn-outline-primary fw-semibold">
                <i class="bi bi-person-plus me-1"></i> Follow
              </button>
            @endif
          </form>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="bg-white border-bottom shadow-sm">
  <div class="container">
    <div class="d-flex justify-content-center justify-content-md-start gap-4 py-3 px-3">
      <div class="text-center">
        <div class="fw-bold">{{ $posts->count() }}</div>
        <small class="text-muted">{{ Str::plural('Post', $posts->count()) }}</small>
      </div>

      <div class="text-center">
        <div class="fw-bold">{{ $followersCount }}</div>
        <small class="text-muted">{{ Str::plural('Follower', $followersCount) }}</small>
      </div>

      <div class="text-center">
        <div class="fw-bold">{{ $followingCount }}</div>
        <small class="text-muted">Following</small>
      </div>
    </div>
  </div>
</div>

<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-transparent border-0">
          <h6 class="mb-0 fw-bold">About</h6>
        </div>

        <div class="card-body pt-0">
          @if($canView)
          <ul class="list-unstyled mb-0">
            @if($userProfile && $userProfile->bio)
            <li class="mb-3">
              <p class="text-muted mb-0">{{ $userProfile->bio }}</p>
            </li>
            @endif

            @if($userProfile && $userProfile->relationshipStatus)
            <li class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-heart text-primary"></i>
              <span class="text-muted">{{ ucfirst($userProfile->relationshipStatus->name) }}</span>
            </li>
            @endif

            <li class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-envelope text-primary"></i>
              <span class="text-muted">{{ $profileUser->email }}</span>
            </li>

            <li class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-calendar3 text-primary"></i>
              <span class="text-muted">{{ \Carbon\Carbon::parse($profileUser->birthdate)->format('F j, Y') }}</span>
            </li>

            @if($userProfile && $userProfile->hometown)
            <li class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-geo-alt text-primary"></i>
              <span class="text-muted">From {{ $userProfile->hometown }}</span>
            </li>
            @endif

            @if($userProfile && $userProfile->current_city)
            <li class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-building text-primary"></i>
              <span class="text-muted">Lives in {{ $userProfile->current_city }}</span>
            </li>
            @endif

            @if($userProfile && $userProfile->website)
            <li class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-globe text-primary"></i>
              <a href="{{ $userProfile->website }}" target="_blank" rel="noopener noreferrer" class="text-muted">{{ $userProfile->website }}</a>
            </li>
            @endif

            <li class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-clock text-primary"></i>
              <span class="text-muted">Joined {{ $profileUser->created_at->format('F Y') }}</span>
            </li>
          </ul>
          @else
          <div class="text-center text-muted py-3">
            <i class="bi bi-lock fs-4 d-block mb-2"></i>
            <small>This information is private.</small>
          </div>
          @endif
        </div>
      </div>

      @if($canView)
      @if($workExperiences->isNotEmpty())
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-transparent border-0">
          <h6 class="mb-0 fw-bold"><i class="bi bi-briefcase me-2 text-primary"></i>Work Experience</h6>
        </div>
        <div class="card-body pt-0">
          @foreach($workExperiences as $work)
          <div class="@if(!$loop->last)mb-3 pb-3 border-bottom @endif">
            <h6 class="fw-semibold mb-0 small">{{ $work->job_title }}</h6>
            <small class="text-muted">{{ $work->company_name }}@if($work->employmentType) &middot; {{ ucfirst($work->employmentType->name) }}@endif</small><br>
            <small class="text-muted">{{ $work->start_date->format('M Y') }} &mdash; {{ $work->is_current ? 'Present' : ($work->end_date ? $work->end_date->format('M Y') : '') }}</small>
            @if($work->description)
            <p class="small text-muted mb-0 mt-1">{{ $work->description }}</p>
            @endif
          </div>
          @endforeach
        </div>
      </div>
      @endif

      @if($academicExperiences->isNotEmpty())
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-transparent border-0">
          <h6 class="mb-0 fw-bold"><i class="bi bi-mortarboard me-2 text-primary"></i>Education</h6>
        </div>
        <div class="card-body pt-0">
          @foreach($academicExperiences as $edu)
          <div class="@if(!$loop->last)mb-3 pb-3 border-bottom @endif">
            <h6 class="fw-semibold mb-0 small">{{ $edu->school_name }}</h6>
            <small class="text-muted">@if($edu->educationLevel){{ ucfirst($edu->educationLevel->name) }}@endif @if($edu->field_of_study) in {{ $edu->field_of_study }}@endif</small><br>
            <small class="text-muted">{{ $edu->start_year }} &mdash; {{ $edu->end_year ?? 'Present' }}</small>
            @if($edu->description)
            <p class="small text-muted mb-0 mt-1">{{ $edu->description }}</p>
            @endif
          </div>
          @endforeach
        </div>
      </div>
      @endif

      @if($datingHistories->isNotEmpty())
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-transparent border-0">
          <h6 class="mb-0 fw-bold"><i class="bi bi-heart me-2 text-primary"></i>Dating History</h6>
        </div>
        <div class="card-body pt-0">
          @foreach($datingHistories as $dating)
          <div class="@if(!$loop->last)mb-3 pb-3 border-bottom @endif">
            <h6 class="fw-semibold mb-0 small">{{ $dating->partner_name }}</h6>
            @if($dating->start_date)
            <small class="text-muted">{{ $dating->start_date->format('M Y') }} &mdash; {{ $dating->end_date ? $dating->end_date->format('M Y') : '' }}</small>
            @endif
            @if($dating->description)
            <p class="small text-muted mb-0 mt-1">{{ $dating->description }}</p>
            @endif
          </div>
          @endforeach
        </div>
      </div>
      @endif
      @endif
    </div>

    <div class="col-lg-8">
      @if($canView)
      @forelse($posts as $post)
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3 mb-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->firstname . ' ' . $post->user->lastname) }}&color=fff&size=46&rounded=true&bold=true" alt="{{ $post->user->firstname }} {{ $post->user->lastname }}" width="46" height="46" class="rounded-circle">
            <div class="flex-grow-1">
              <h6 class="mb-0">
                <a href="{{ route('profile.show', $post->user->username) }}" class="text-decoration-none text-dark">
                  {{ $post->user->firstname }} {{ $post->user->lastname }}
                </a>
              </h6>
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
        <div class="card-body text-center text-muted py-5">
          <i class="bi bi-chat-square-text fs-1 mb-2 d-block"></i>
          <p class="mb-0">
            @if(Auth::id() === $profileUser->id)
              You haven't posted anything yet. Share something!
            @else
              {{ $profileUser->firstname }} hasn't posted anything yet.
            @endif
          </p>
        </div>
      </div>
      @endforelse
      @else
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body text-center text-muted py-5">
          <i class="bi bi-lock fs-1 mb-2 d-block"></i>
          <h6 class="fw-semibold">This Account is Private</h6>
          <p class="mb-0">You need to be friends with {{ $profileUser->firstname }} to see their posts.</p>
        </div>
      </div>
      @endif

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
