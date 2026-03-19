<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Services\Profile\ProfileService;
use App\Services\Settings\SettingsService;

class ProfileController extends Controller {
  public function __construct(
    protected ProfileService $profileService,
    protected SettingsService $settingsService,
  ) {
  }

  public function show(string $username) {
    $user = $this->profileService->getUserByUsername($username);

    if (!$user) {
      abort(404);
    }

    $posts = $this->profileService->getUserPosts($user->id);
    $friendsCount = $this->profileService->getFriendsCount($user->id);
    $followersCount = $this->profileService->getFollowersCount($user->id);
    $followingCount = $this->profileService->getFollowingCount($user->id);
    $friendshipStatus = $this->profileService->getFriendshipStatus(auth()->id(), $user->id);
    $isFollowing = $this->profileService->isFollowing(auth()->id(), $user->id);
    $canView = $this->profileService->canViewProfile(auth()->id(), $user->id);
    $isPrivate = $this->profileService->isPrivate($user->id);

    $userProfile = $this->settingsService->getUserProfile($user->id);
    $workExperiences = $this->settingsService->getWorkExperiences($user->id);
    $academicExperiences = $this->settingsService->getAcademicExperiences($user->id);
    $datingHistories = $this->settingsService->getDatingHistories($user->id);

    return view("pages.profile.show")
      ->with([
        "profileUser" => $user,
        "posts" => $posts,
        "friendsCount" => $friendsCount,
        "followersCount" => $followersCount,
        "followingCount" => $followingCount,
        "friendshipStatus" => $friendshipStatus,
        "isFollowing" => $isFollowing,
        "canView" => $canView,
        "isPrivate" => $isPrivate,
        "userProfile" => $userProfile,
        "workExperiences" => $workExperiences,
        "academicExperiences" => $academicExperiences,
        "datingHistories" => $datingHistories,
      ]);
  }
}
