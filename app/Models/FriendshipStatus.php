<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FriendshipStatus extends Model {
  public $timestamps = false;

  public function friendships(): HasMany {
    return $this->hasMany(Friendship::class);
  }

  public function getIdByName(string $name): int {
    return $this->where('name', $name)->first()->id;
  }
}
