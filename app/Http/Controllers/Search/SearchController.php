<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller {
  public function __construct(protected SearchService $searchService) {
  }

  public function index(Request $request) {
    $query = $request->input('q', '');
    $users = collect();
    $posts = collect();

    if (strlen(trim($query)) >= 1) {
      $users = $this->searchService->searchUsers(trim($query));
      $posts = $this->searchService->searchPosts(trim($query));
    }

    return view('pages.search.index')
      ->with('query', $query)
      ->with('users', $users)
      ->with('posts', $posts);
  }
}
