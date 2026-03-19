<?php

namespace App\Services\Home;

use App\Models\Category;

class HomeService {
  public function __construct(protected Category $category) {
  }

  public function getAllCategories() {
    return $this->category->all();
  }
}
