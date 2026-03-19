<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegistrationRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool {
    return !Auth::check();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array {
    return [
      "firstname" => ["required", "string", "max:255"],
      "middlename" => ["nullable", "string", "max:255"],
      "lastname" => ["required", "string", "max:255"],
      "username" => ["required", "string", "max:255", "unique:users,username"],
      "email" => ["required", "email", "max:255", "unique:users,email"],
      "password" => ["required", "string", "min:8", "confirmed"],
      "birthdate" => ["required", "date"],
      "sex_id" => ["required", "exists:sexes,id"]
    ];
  }
}
