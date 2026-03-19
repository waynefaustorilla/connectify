<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class WorkExperienceRequest extends FormRequest {
  public function authorize(): bool {
    return true;
  }

  public function rules(): array {
    return [
      'company_name' => ['required', 'string', 'max:255'],
      'job_title' => ['required', 'string', 'max:255'],
      'employment_type_id' => ['nullable', 'exists:employment_types,id'],
      'start_date' => ['required', 'date'],
      'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
      'description' => ['nullable', 'string', 'max:1000'],
      'is_current' => ['nullable', 'boolean'],
    ];
  }
}
