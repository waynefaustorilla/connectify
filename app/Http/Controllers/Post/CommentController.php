<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CommentRequest;
use App\Services\Posts\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller {
  public function __construct(protected CommentService $commentService) {
  }

  public function store(CommentRequest $request, int $post) {
    $this->commentService->createComment([
      'content' => $request->input('content'),
      'user_id' => $request->user()->id,
      'post_id' => $post,
      'parent_id' => $request->input('parent_id'),
    ]);

    return redirect()->back();
  }

  public function destroy(Request $request, int $comment) {
    $this->commentService->deleteComment($comment, $request->user()->id);

    return redirect()->back();
  }
}
