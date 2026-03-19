<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(["title", "content", "category_id", "user_id"])]
class Posts extends Model {
}
