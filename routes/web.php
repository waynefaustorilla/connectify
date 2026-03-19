<?php

use Illuminate\Support\Facades\Route;

Route::get("/login", [App\Http\Controllers\Auth\LoginController::class, "show_login_form"])->name("auth.login");
Route::post("/login", [App\Http\Controllers\Auth\LoginController::class, "login"]);

Route::get("/registration", [App\Http\Controllers\Auth\RegistrationController::class, "show_registration_form"])->name("auth.registration");
Route::post("/registration", [App\Http\Controllers\Auth\RegistrationController::class, "register"]);

Route::middleware(["auth", "verified"])->group(function () {
  Route::get("/", [App\Http\Controllers\Home\HomeController::class, "index"])->name("home.index");

  Route::post("/posts", [App\Http\Controllers\Post\PostController::class, "store"])->name("posts.store");
});
