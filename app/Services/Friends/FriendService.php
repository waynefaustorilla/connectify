<?php

namespace App\Services\Friends;

use App\Models\Friendship;
use App\Models\FriendshipStatus;
use App\Services\Notifications\NotificationService;

class FriendService {
  public function __construct(
    protected Friendship $friendship,
    protected FriendshipStatus $friendshipStatus,
    protected NotificationService $notificationService,
  ) {
  }

  public function getFriends(int $userId) {
    $acceptedId = $this->friendshipStatus->getIdByName('accepted');

    $friendships = $this->friendship->getFriendshipsByUserAndStatus($userId, $acceptedId);

    return $friendships->map(function ($friendship) use ($userId) {
      return $friendship->sender_id === $userId
        ? $friendship->receiver
        : $friendship->sender;
    });
  }

  public function getReceivedRequests(int $userId) {
    $pendingId = $this->friendshipStatus->getIdByName('pending');

    return $this->friendship->getReceivedByStatus($userId, $pendingId)
      ->pluck('sender');
  }

  public function getSentRequests(int $userId) {
    $pendingId = $this->friendshipStatus->getIdByName('pending');

    return $this->friendship->getSentByStatus($userId, $pendingId)
      ->pluck('receiver');
  }

  public function acceptRequest(int $senderId, int $receiverId): bool {
    $pendingId = $this->friendshipStatus->getIdByName('pending');
    $acceptedId = $this->friendshipStatus->getIdByName('accepted');

    $friendship = $this->friendship->findBySenderReceiverAndStatus($senderId, $receiverId, $pendingId);

    if (!$friendship) {
      return false;
    }

    $friendship->update(['friendship_status_id' => $acceptedId]);

    $this->notificationService->notifyFriendAccepted($senderId, $receiverId);

    return true;
  }

  public function declineRequest(int $senderId, int $receiverId): bool {
    $pendingId = $this->friendshipStatus->getIdByName('pending');
    $declinedId = $this->friendshipStatus->getIdByName('declined');

    $friendship = $this->friendship->findBySenderReceiverAndStatus($senderId, $receiverId, $pendingId);

    if (!$friendship) {
      return false;
    }

    $friendship->update(['friendship_status_id' => $declinedId]);
    return true;
  }

  public function sendRequest(int $senderId, int $receiverId): bool {
    $exists = $this->friendship->findBetweenUsers($senderId, $receiverId);

    if ($exists) {
      return false;
    }

    $pendingId = $this->friendshipStatus->getIdByName('pending');

    $this->friendship->create([
      'sender_id' => $senderId,
      'receiver_id' => $receiverId,
      'friendship_status_id' => $pendingId,
    ]);

    $this->notificationService->notifyFriendRequest($receiverId, $senderId);

    return true;
  }

  public function unfriend(int $userId, int $friendId): bool {
    $friendship = $this->friendship->findBetweenUsers($userId, $friendId);

    if (!$friendship) {
      return false;
    }

    $friendship->delete();
    return true;
  }

  public function cancelRequest(int $senderId, int $receiverId): bool {
    $pendingId = $this->friendshipStatus->getIdByName('pending');

    $friendship = $this->friendship->findBySenderReceiverAndStatus($senderId, $receiverId, $pendingId);

    if (!$friendship) {
      return false;
    }

    $friendship->delete();
    return true;
  }
}
