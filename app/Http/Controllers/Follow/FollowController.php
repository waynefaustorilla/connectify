<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use App\Services\Follow\FollowService;
use Illuminate\Http\Request;

class FollowController extends Controller {
  public function __construct(protected FollowService $followService) {
  }

  public function toggle(Request $request, int $user) {
    $this->followService->toggleFollow($request->user()->id, $user);

    return redirect()->back();
  }
}
