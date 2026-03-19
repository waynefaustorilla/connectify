<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class LogoutController extends Controller {
  public function __construct(protected AuthService $authService) {
  }

  public function logout(Request $request) {
    $this->authService->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route("auth.login");
  }
}
