<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use App\Services\Posts\PostService;

class PostController extends Controller {
  public function __construct(protected PostService $postService) {
  }

  public function store(PostRequest $request) {
    $this->postService->createPost([
      'title' => $request->input('title'),
      'content' => $request->input('content'),
      'category_id' => $request->input('category_id'),
      'user_id' => $request->user()->id,
    ]);

    return redirect()->route("home.index");
  }

  public function show(int $post) {
    $post = $this->postService->getPostWithDetails($post);

    if (!$post) {
      abort(404);
    }

    return view('pages.posts.show')->with('post', $post);
  }
}
