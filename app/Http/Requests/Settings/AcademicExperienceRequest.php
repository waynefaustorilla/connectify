<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AcademicExperienceRequest extends FormRequest {
  public function authorize(): bool {
    return true;
  }

  public function rules(): array {
    return [
      'school_name' => ['required', 'string', 'max:255'],
      'education_level_id' => ['nullable', 'exists:education_levels,id'],
      'field_of_study' => ['nullable', 'string', 'max:255'],
      'start_year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 10)],
      'end_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 10), 'gte:start_year'],
      'description' => ['nullable', 'string', 'max:1000'],
    ];
  }
}
