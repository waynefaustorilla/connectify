<?php

namespace App\Services\Notifications;

use App\Models\Notification;

class NotificationService {
  public function __construct(
    protected Notification $notification
  ) {
  }

  public function getNotifications(int $userId) {
    return $this->notification->getByUserId($userId);
  }

  public function getUnreadCount(int $userId): int {
    return $this->notification->countUnread($userId);
  }

  public function markAllAsRead(int $userId): void {
    $this->notification->markAllAsRead($userId);
  }

  public function markAsRead(int $notificationId, int $userId): bool {
    return $this->notification->markAsRead($notificationId, $userId);
  }

  public function findForUser(int $notificationId, int $userId): ?Notification {
    return $this->notification->where('id', $notificationId)
      ->where('user_id', $userId)
      ->with('sender')
      ->first();
  }

  public function createNotification(int $userId, int $senderId, string $type, ?string $notifiableType = null, ?int $notifiableId = null): void {
    if ($userId === $senderId) {
      return;
    }

    $this->notification->create([
      'user_id' => $userId,
      'sender_id' => $senderId,
      'type' => $type,
      'notifiable_type' => $notifiableType,
      'notifiable_id' => $notifiableId,
    ]);
  }

  public function notifyLike(int $postOwnerId, int $likerId, int $postId): void {
    $this->createNotification($postOwnerId, $likerId, 'like', 'App\Models\Post', $postId);
  }

  public function notifyComment(int $postOwnerId, int $commenterId, int $postId): void {
    $this->createNotification($postOwnerId, $commenterId, 'comment', 'App\Models\Post', $postId);
  }

  public function notifyFriendRequest(int $receiverId, int $senderId): void {
    $this->createNotification($receiverId, $senderId, 'friend_request');
  }

  public function notifyFriendAccepted(int $senderId, int $accepterId): void {
    $this->createNotification($senderId, $accepterId, 'friend_accepted');
  }

  public function notifyFollow(int $followedUserId, int $followerId): void {
    $this->createNotification($followedUserId, $followerId, 'follow');
  }
}
