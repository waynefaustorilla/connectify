<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['user_id', 'sender_id', 'type', 'notifiable_type', 'notifiable_id'])]
class Notification extends Model {
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function sender(): BelongsTo {
    return $this->belongsTo(User::class, 'sender_id');
  }

  public function notifiable(): MorphTo {
    return $this->morphTo();
  }

  public function getByUserId(int $userId) {
    return $this->where('user_id', $userId)
      ->with('sender')
      ->latest()
      ->limit(50)
      ->get();
  }

  public function countUnread(int $userId): int {
    return $this->where('user_id', $userId)
      ->whereNull('read_at')
      ->count();
  }

  public function markAllAsRead(int $userId): void {
    $this->where('user_id', $userId)
      ->whereNull('read_at')
      ->update(['read_at' => now()]);
  }

  public function markAsRead(int $notificationId, int $userId): bool {
    $notification = $this->where('id', $notificationId)
      ->where('user_id', $userId)
      ->first();

    if (!$notification) {
      return false;
    }

    $notification->update(['read_at' => now()]);
    return true;
  }
}
