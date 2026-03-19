<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'relationship_status_id', 'bio', 'hometown', 'current_city', 'website'])]
class UserProfile extends Model {
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function relationshipStatus(): BelongsTo {
    return $this->belongsTo(RelationshipStatus::class);
  }
}
