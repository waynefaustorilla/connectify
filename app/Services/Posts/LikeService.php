<?php

namespace App\Services\Posts;

use App\Models\Like;
use App\Models\Post;
use App\Services\Notifications\NotificationService;

class LikeService {
  public function __construct(
    protected Like $like,
    protected Post $post,
    protected NotificationService $notificationService,
  ) {
  }

  public function toggleLike(int $userId, int $postId): bool {
    $existing = $this->like->findByUserAndPost($userId, $postId);

    if ($existing) {
      $existing->delete();
      return false;
    }

    $this->like->create([
      'user_id' => $userId,
      'post_id' => $postId,
    ]);

    $post = $this->post->find($postId);
    if ($post) {
      $this->notificationService->notifyLike($post->user_id, $userId, $postId);
    }

    return true;
  }
}
