<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest {
  public function authorize(): bool {
    return true;
  }

  public function rules(): array {
    return [
      'bio' => ['nullable', 'string', 'max:1000'],
      'hometown' => ['nullable', 'string', 'max:255'],
      'current_city' => ['nullable', 'string', 'max:255'],
      'website' => ['nullable', 'url', 'max:255'],
      'relationship_status_id' => ['nullable', 'exists:relationship_statuses,id'],
    ];
  }
}
