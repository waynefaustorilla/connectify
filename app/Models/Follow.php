<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['follower_id', 'following_id'])]
class Follow extends Model {
  public function follower(): BelongsTo {
    return $this->belongsTo(User::class, 'follower_id');
  }

  public function following(): BelongsTo {
    return $this->belongsTo(User::class, 'following_id');
  }

  public function findByFollowerAndFollowing(int $followerId, int $followingId): ?self {
    return $this->where('follower_id', $followerId)
      ->where('following_id', $followingId)
      ->first();
  }

  public function countFollowers(int $userId): int {
    return $this->where('following_id', $userId)->count();
  }

  public function countFollowing(int $userId): int {
    return $this->where('follower_id', $userId)->count();
  }

  public function getFollowers(int $userId) {
    return $this->where('following_id', $userId)
      ->with('follower')
      ->get();
  }

  public function getFollowing(int $userId) {
    return $this->where('follower_id', $userId)
      ->with('following')
      ->get();
  }
}
