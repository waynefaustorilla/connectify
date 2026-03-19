<?php

namespace App\Services\Auth;

use App\Models\Sex;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService {
  public function __construct(
    protected User $user,
    protected Sex $sex,
  ) {
  }

  public function getAllSexes() {
    return $this->sex->all();
  }

  public function register(array $data): User {
    $user = $this->user->create([
      'firstname' => $data['firstname'],
      'middlename' => $data['middlename'],
      'lastname' => $data['lastname'],
      'username' => $data['username'],
      'email' => $data['email'],
      'sex_id' => $data['sex_id'],
      'password' => bcrypt($data['password']),
      'birthdate' => $data['birthdate'],
    ]);

    Auth::login($user);

    return $user;
  }

  public function login(string $email, string $password): bool {
    return Auth::attempt([
      'email' => $email,
      'password' => $password,
    ]);
  }
}
