<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationLevel extends Model {
  public $timestamps = false;

  public function academicExperiences(): HasMany {
    return $this->hasMany(AcademicExperience::class);
  }
}
