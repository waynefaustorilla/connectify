<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'company_name', 'job_title', 'employment_type_id', 'start_date', 'end_date', 'description', 'is_current'])]
class WorkExperience extends Model {
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function employmentType(): BelongsTo {
    return $this->belongsTo(EmploymentType::class);
  }

  protected function casts(): array {
    return [
      'start_date' => 'date',
      'end_date' => 'date',
      'is_current' => 'boolean',
    ];
  }
}
