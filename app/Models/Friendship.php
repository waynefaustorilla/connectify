<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['sender_id', 'receiver_id', 'friendship_status_id'])]
class Friendship extends Model {
  public function sender(): BelongsTo {
    return $this->belongsTo(User::class, 'sender_id');
  }

  public function receiver(): BelongsTo {
    return $this->belongsTo(User::class, 'receiver_id');
  }

  public function status(): BelongsTo {
    return $this->belongsTo(FriendshipStatus::class, 'friendship_status_id');
  }

  public function getFriendshipsByUserAndStatus(int $userId, int $statusId) {
    return $this->where(function ($query) use ($userId) {
      $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
    })
      ->where('friendship_status_id', $statusId)
      ->with(['sender', 'receiver'])
      ->get();
  }

  public function getReceivedByStatus(int $receiverId, int $statusId) {
    return $this->where('receiver_id', $receiverId)
      ->where('friendship_status_id', $statusId)
      ->with('sender')
      ->get();
  }

  public function getSentByStatus(int $senderId, int $statusId) {
    return $this->where('sender_id', $senderId)
      ->where('friendship_status_id', $statusId)
      ->with('receiver')
      ->get();
  }

  public function findBySenderReceiverAndStatus(int $senderId, int $receiverId, int $statusId): ?self {
    return $this->where('sender_id', $senderId)
      ->where('receiver_id', $receiverId)
      ->where('friendship_status_id', $statusId)
      ->first();
  }

  public function findBetweenUsers(int $userId1, int $userId2): ?self {
    return $this->where(function ($query) use ($userId1, $userId2) {
      $query->where('sender_id', $userId1)->where('receiver_id', $userId2);
    })
      ->orWhere(function ($query) use ($userId1, $userId2) {
        $query->where('sender_id', $userId2)->where('receiver_id', $userId1);
      })
      ->first();
  }

  public function countByUserAndStatus(int $userId, int $statusId): int {
    return $this->where(function ($query) use ($userId) {
      $query->where('sender_id', $userId)
        ->orWhere('receiver_id', $userId);
    })->where('friendship_status_id', $statusId)->count();
  }

  public function countFollowers(int $userId, int $statusId): int {
    return $this->where('receiver_id', $userId)
      ->where('friendship_status_id', $statusId)
      ->count();
  }

  public function countFollowing(int $userId, int $statusId): int {
    return $this->where('sender_id', $userId)
      ->where('friendship_status_id', $statusId)
      ->count();
  }

  public function getFollowers(int $userId, int $statusId) {
    return $this->where('receiver_id', $userId)
      ->where('friendship_status_id', $statusId)
      ->with('sender')
      ->get();
  }

  public function getFollowing(int $userId, int $statusId) {
    return $this->where('sender_id', $userId)
      ->where('friendship_status_id', $statusId)
      ->with('receiver')
      ->get();
  }
}
