<?php

namespace App\Services\Profile;

use App\Models\Friendship;
use App\Models\FriendshipStatus;
use App\Models\Post;
use App\Models\User;
use App\Services\Follow\FollowService;
use App\Services\Settings\SettingsService;

class ProfileService {
  public function __construct(
    protected User $user,
    protected Post $post,
    protected FriendshipStatus $friendshipStatus,
    protected Friendship $friendship,
    protected FollowService $followService,
    protected SettingsService $settingsService,
  ) {
  }

  public function getUserByUsername(string $username): ?User {
    return $this->user->findByUsername($username);
  }

  public function getUserPosts(int $userId) {
    return $this->post->getByUserIdWithDetails($userId);
  }

  public function getFriendsCount(int $userId): int {
    $acceptedId = $this->friendshipStatus->getIdByName('accepted');

    return $this->friendship->countByUserAndStatus($userId, $acceptedId);
  }

  public function getFollowersCount(int $userId): int {
    return $this->followService->getFollowersCount($userId);
  }

  public function getFollowingCount(int $userId): int {
    return $this->followService->getFollowingCount($userId);
  }

  public function isFollowing(int $followerId, int $followingId): bool {
    return $this->followService->isFollowing($followerId, $followingId);
  }

  public function getFriendshipStatus(int $authId, int $profileId): ?array {
    $friendship = $this->friendship->findBetweenUsers($authId, $profileId);

    if (!$friendship) {
      return null;
    }

    return [
      'status' => $friendship->status->name,
      'is_sender' => $friendship->sender_id === $authId,
    ];
  }

  public function isPrivate(int $userId): bool {
    return $this->settingsService->isPrivate($userId);
  }

  public function canViewProfile(int $authId, int $profileId): bool {
    if ($authId === $profileId) {
      return true;
    }

    if (!$this->isPrivate($profileId)) {
      return true;
    }

    $acceptedId = $this->friendshipStatus->getIdByName('accepted');
    $friendship = $this->friendship->findBetweenUsers($authId, $profileId);

    return $friendship && $friendship->friendship_status_id === $acceptedId;
  }
}
