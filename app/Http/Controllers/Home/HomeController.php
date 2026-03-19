<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\HomeService;

class HomeController extends Controller {
  public function __construct(
    protected HomeService $homeService,
  ) {}

  public function index() {
    $categories = $this->homeService->getAllCategories();

    return view("pages.home.index")->with("categories", $categories);
  }
}
