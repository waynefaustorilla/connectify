<?php

namespace App\Services\Search;

use App\Models\Post;
use App\Models\User;

class SearchService {
  public function __construct(
    protected User $user,
    protected Post $post
  ) {
  }

  public function searchUsers(string $query) {
    return $this->user->searchByNameOrUsername($query);
  }

  public function searchPosts(string $query) {
    return $this->post->searchByTitleOrContent($query);
  }
}
