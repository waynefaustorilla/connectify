<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploymentType extends Model {
  public $timestamps = false;

  public function workExperiences(): HasMany {
    return $this->hasMany(WorkExperience::class);
  }
}
