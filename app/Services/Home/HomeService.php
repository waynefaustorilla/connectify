<?php

namespace App\Services\Home;

use App\Models\Category;
use App\Models\Post;
use App\Services\Follow\FollowService;

class HomeService {
  public function __construct(
    protected Category $category,
    protected Post $post,
    protected FollowService $followService,
  ) {
  }

  public function getAllCategories() {
    return $this->category->all();
  }

  public function getPosts() {
    return $this->post->getAllWithUserAndLikes();
  }

  public function getPostsCount(int $userId): int {
    return $this->post->where('user_id', $userId)->count();
  }

  public function getFollowersCount(int $userId): int {
    return $this->followService->getFollowersCount($userId);
  }

  public function getFollowingCount(int $userId): int {
    return $this->followService->getFollowingCount($userId);
  }
}
