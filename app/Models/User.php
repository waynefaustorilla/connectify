<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['firstname', 'middlename', 'lastname', 'username', 'email', 'sex_id', 'password', 'birthdate'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable {

  use HasFactory, Notifiable;

  protected function casts(): array {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function sentFriendRequests(): HasMany {
    return $this->hasMany(Friendship::class, 'sender_id');
  }

  public function receivedFriendRequests(): HasMany {
    return $this->hasMany(Friendship::class, 'receiver_id');
  }

  public function likes(): HasMany {
    return $this->hasMany(Like::class);
  }

  public function comments(): HasMany {
    return $this->hasMany(Comment::class);
  }

  public function followers(): HasMany {
    return $this->hasMany(Follow::class, 'following_id');
  }

  public function following(): HasMany {
    return $this->hasMany(Follow::class, 'follower_id');
  }

  public function settings(): HasOne {
    return $this->hasOne(UserSetting::class);
  }

  public function profile(): HasOne {
    return $this->hasOne(UserProfile::class);
  }

  public function workExperiences(): HasMany {
    return $this->hasMany(WorkExperience::class);
  }

  public function academicExperiences(): HasMany {
    return $this->hasMany(AcademicExperience::class);
  }

  public function datingHistories(): HasMany {
    return $this->hasMany(DatingHistory::class);
  }

  public function findByUsername(string $username): ?self {
    return $this->where('username', $username)->first();
  }

  public function searchByNameOrUsername(string $query) {
    return $this->where('firstname', 'like', "%{$query}%")
      ->orWhere('lastname', 'like', "%{$query}%")
      ->orWhere('username', 'like', "%{$query}%")
      ->limit(20)
      ->get();
  }
}
