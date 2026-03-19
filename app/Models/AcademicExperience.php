<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'school_name', 'education_level_id', 'field_of_study', 'start_year', 'end_year', 'description'])]
class AcademicExperience extends Model {
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function educationLevel(): BelongsTo {
    return $this->belongsTo(EducationLevel::class);
  }
}
