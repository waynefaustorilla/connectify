<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(["title", "content", "category_id", "user_id"])]
class Post extends Model {
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function category(): BelongsTo {
    return $this->belongsTo(Category::class);
  }

  public function likes(): HasMany {
    return $this->hasMany(Like::class);
  }

  public function comments(): HasMany {
    return $this->hasMany(Comment::class);
  }

  public function getAllWithUserAndLikes() {
    return $this->with('user', 'likes', 'comments.user', 'comments.replies.user')->withCount('likes', 'comments')->latest()->get();
  }

  public function getByUserIdWithDetails(int $userId) {
    return $this->where('user_id', $userId)
      ->with('user', 'category', 'likes', 'comments.user', 'comments.replies.user')
      ->withCount('likes', 'comments')
      ->latest()
      ->get();
  }

  public function searchByTitleOrContent(string $query) {
    return $this->where('title', 'like', "%{$query}%")
      ->orWhere('content', 'like', "%{$query}%")
      ->with('user', 'category', 'likes', 'comments.user', 'comments.replies.user')
      ->withCount('likes', 'comments')
      ->latest()
      ->limit(20)
      ->get();
  }
}
