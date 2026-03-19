<?php

namespace App\Services\Follow;

use App\Models\Follow;
use App\Services\Notifications\NotificationService;

class FollowService {
  public function __construct(
    protected Follow $follow,
    protected NotificationService $notificationService,
  ) {
  }

  public function toggleFollow(int $followerId, int $followingId): bool {
    if ($followerId === $followingId) {
      return false;
    }

    $existing = $this->follow->findByFollowerAndFollowing($followerId, $followingId);

    if ($existing) {
      $existing->delete();
      return false;
    }

    $this->follow->create([
      'follower_id' => $followerId,
      'following_id' => $followingId,
    ]);

    $this->notificationService->notifyFollow($followingId, $followerId);

    return true;
  }

  public function isFollowing(int $followerId, int $followingId): bool {
    return $this->follow->findByFollowerAndFollowing($followerId, $followingId) !== null;
  }

  public function getFollowersCount(int $userId): int {
    return $this->follow->countFollowers($userId);
  }

  public function getFollowingCount(int $userId): int {
    return $this->follow->countFollowing($userId);
  }

  public function getFollowers(int $userId) {
    return $this->follow->getFollowers($userId)->pluck('follower');
  }

  public function getFollowing(int $userId) {
    return $this->follow->getFollowing($userId)->pluck('following');
  }
}
