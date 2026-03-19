<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\HomeService;

class HomeController extends Controller {
  public function __construct(protected HomeService $homeService) {
  }

  public function index() {
    $userId = auth()->id();
    $categories = $this->homeService->getAllCategories();
    $posts = $this->homeService->getPosts();
    $postsCount = $this->homeService->getPostsCount($userId);
    $followersCount = $this->homeService->getFollowersCount($userId);
    $followingCount = $this->homeService->getFollowingCount($userId);

    return view("pages.home.index")
      ->with([
        "categories" => $categories,
        "posts" => $posts,
        "postsCount" => $postsCount,
        "followersCount" => $followersCount,
        "followingCount" => $followingCount,
      ]);
  }
}
