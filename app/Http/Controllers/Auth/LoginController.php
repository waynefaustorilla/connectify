<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;

class LoginController extends Controller {
  public function __construct(protected AuthService $authService) {
  }

  public function show_login_form() {
    return view("pages.auth.login");
  }

  public function login(LoginRequest $request) {
    $attempt = $this->authService->login(
      $request->input("email"),
      $request->input("password"),
    );

    if (!$attempt) {
      return back()->withErrors([
        "email" => "The provided credentials do not match our records.",
      ]);
    }

    return redirect()->route("home.index");
  }
}
