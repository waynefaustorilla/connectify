<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'post_id'])]
class Like extends Model {
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function post(): BelongsTo {
    return $this->belongsTo(Post::class);
  }

  public function findByUserAndPost(int $userId, int $postId): ?self {
    return $this->where('user_id', $userId)->where('post_id', $postId)->first();
  }
}
