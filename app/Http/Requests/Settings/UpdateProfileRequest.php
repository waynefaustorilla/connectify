<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest {
  public function authorize(): bool {
    return true;
  }

  /**
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array {
    $userId = $this->user()->id;

    return [
      "firstname" => ["required", "string", "max:255"],
      "middlename" => ["nullable", "string", "max:255"],
      "lastname" => ["required", "string", "max:255"],
      "username" => ["required", "string", "max:255", "unique:users,username,{$userId}"],
      "email" => ["required", "email", "max:255", "unique:users,email,{$userId}"],
      "birthdate" => ["required", "date"],
      "sex_id" => ["required", "exists:sexes,id"],
    ];
  }
}
