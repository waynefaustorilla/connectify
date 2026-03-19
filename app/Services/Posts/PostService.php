<?php

namespace App\Services\Posts;

use App\Models\Posts;

class PostService {
  public function __construct(
    protected Posts $post,
  ) {
  }

  public function createPost(array $data): Posts {
    return $this->post->create([
      'title' => trim($data['title']),
      'content' => trim($data['content']),
      'category_id' => $data['category_id'],
      'user_id' => $data['user_id'],
    ]);
  }
}
