<?php

namespace App\Services\Posts;

use App\Models\Post;

class PostService {
  public function __construct(
    protected Post $post
  ) {
  }

  public function createPost(array $data): Post {
    return $this->post->create([
      'title' => trim($data['title']),
      'content' => trim($data['content']),
      'category_id' => $data['category_id'],
      'user_id' => $data['user_id'],
    ]);
  }

  public function getPostWithDetails(int $postId): ?Post {
    return $this->post->with('user', 'category', 'likes', 'comments.user', 'comments.replies.user')
      ->withCount('likes', 'comments')
      ->find($postId);
  }
}
