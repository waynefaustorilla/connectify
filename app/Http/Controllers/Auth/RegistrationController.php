<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller {
  public function __construct(protected AuthService $authService) {
  }

  public function show_registration_form() {
    $sexes = $this->authService->getAllSexes();

    return view("pages.auth.registration")->with("sexes", $sexes);
  }

  public function register(RegistrationRequest $request) {
    $user = $this->authService->register($request->validated());

    Auth::login($user);

    return redirect()->route("home.index");
  }
}
