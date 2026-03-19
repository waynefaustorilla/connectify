<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\Posts\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller {
  public function __construct(protected LikeService $likeService) {
  }

  public function toggle(Request $request, int $post) {
    $liked = $this->likeService->toggleLike($request->user()->id, $post);

    return redirect()->back()->with('liked', $liked);
  }
}
