<?php

namespace App\Services\Posts;

use App\Models\Comment;
use App\Models\Post;
use App\Services\Notifications\NotificationService;

class CommentService {
  public function __construct(
    protected Comment $comment,
    protected Post $post,
    protected NotificationService $notificationService,
  ) {
  }

  public function createComment(array $data): Comment {
    $comment = $this->comment->create([
      'content' => trim($data['content']),
      'user_id' => $data['user_id'],
      'post_id' => $data['post_id'],
      'parent_id' => $data['parent_id'] ?? null,
    ]);

    $post = $this->post->find($data['post_id']);
    if ($post) {
      $this->notificationService->notifyComment($post->user_id, $data['user_id'], $data['post_id']);
    }

    return $comment;
  }

  public function deleteComment(int $commentId, int $userId): bool {
    $comment = $this->comment->find($commentId);

    if (!$comment || $comment->user_id !== $userId) {
      return false;
    }

    return $comment->delete();
  }
}
