<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'partner_name', 'start_date', 'end_date', 'description'])]
class DatingHistory extends Model {
  protected $table = 'dating_histories';

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  protected function casts(): array {
    return [
      'start_date' => 'date',
      'end_date' => 'date',
    ];
  }
}
