<?php

namespace App\Http\Controllers\Friends;

use App\Http\Controllers\Controller;
use App\Services\Follow\FollowService;
use App\Services\Friends\FriendService;
use Illuminate\Http\Request;

class FriendsController extends Controller {
  public function __construct(
    protected FriendService $friendService,
    protected FollowService $followService,
  ) {
  }

  public function index(Request $request) {
    $userId = $request->user()->id;

    $friends = $this->friendService->getFriends($userId);
    $receivedRequests = $this->friendService->getReceivedRequests($userId);
    $sentRequests = $this->friendService->getSentRequests($userId);
    $followers = $this->followService->getFollowers($userId);
    $following = $this->followService->getFollowing($userId);

    return view('pages.friends.index')
      ->with([
        'friends' => $friends,
        'receivedRequests' => $receivedRequests,
        'sentRequests' => $sentRequests,
        'followers' => $followers,
        'following' => $following,
      ]);
  }

  public function accept(Request $request, int $sender) {
    $this->friendService->acceptRequest($sender, $request->user()->id);

    return redirect()->route('friends.index')->with('success', 'Friend request accepted.');
  }

  public function decline(Request $request, int $sender) {
    $this->friendService->declineRequest($sender, $request->user()->id);

    return redirect()->route('friends.index')->with('success', 'Friend request declined.');
  }

  public function send(Request $request, int $receiver) {
    $this->friendService->sendRequest($request->user()->id, $receiver);

    return redirect()->back()->with('success', 'Friend request sent.');
  }

  public function unfriend(Request $request, int $friend) {
    $this->friendService->unfriend($request->user()->id, $friend);

    return redirect()->route('friends.index')->with('success', 'Friend removed.');
  }

  public function cancel(Request $request, int $receiver) {
    $this->friendService->cancelRequest($request->user()->id, $receiver);

    return redirect()->route('friends.index')->with('success', 'Friend request cancelled.');
  }
}
