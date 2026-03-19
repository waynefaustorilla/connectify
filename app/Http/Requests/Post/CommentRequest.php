<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest {
  public function authorize(): bool {
    return Auth::check();
  }

  public function rules(): array {
    return [
      "content" => ["required", "string", "max:5000"],
      "parent_id" => ["nullable", "integer", "exists:comments,id"],
    ];
  }
}
