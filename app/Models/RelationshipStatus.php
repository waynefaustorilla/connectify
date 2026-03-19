<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RelationshipStatus extends Model {
  public $timestamps = false;

  public function userProfiles(): HasMany {
    return $this->hasMany(UserProfile::class);
  }
}
