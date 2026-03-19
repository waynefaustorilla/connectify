<?php

use Illuminate\Support\Facades\Route;

Route::get("/login", [App\Http\Controllers\Auth\LoginController::class, "show_login_form"])->name("auth.login");
Route::post("/login", [App\Http\Controllers\Auth\LoginController::class, "login"]);

Route::get("/registration", [App\Http\Controllers\Auth\RegistrationController::class, "show_registration_form"])->name("auth.registration");
Route::post("/registration", [App\Http\Controllers\Auth\RegistrationController::class, "register"]);

Route::middleware(["auth"])->group(function () {
  Route::get("/", [App\Http\Controllers\Home\HomeController::class, "index"])->name("home.index");

  Route::post("/logout", [App\Http\Controllers\Auth\LogoutController::class, "logout"])->name("auth.logout");

  Route::post("/posts", [App\Http\Controllers\Post\PostController::class, "store"])->name("posts.store");
  Route::get("/posts/{post}", [App\Http\Controllers\Post\PostController::class, "show"])->name("posts.show");
  Route::post("/posts/{post}/like", [App\Http\Controllers\Post\LikeController::class, "toggle"])->name("posts.like");
  Route::post("/posts/{post}/comments", [App\Http\Controllers\Post\CommentController::class, "store"])->name("comments.store");
  Route::delete("/comments/{comment}", [App\Http\Controllers\Post\CommentController::class, "destroy"])->name("comments.destroy");

  Route::get("/profile/{username}", [App\Http\Controllers\Profile\ProfileController::class, "show"])->name("profile.show");

  Route::get("/search", [App\Http\Controllers\Search\SearchController::class, "index"])->name("search");

  Route::get("/friends", [App\Http\Controllers\Friends\FriendsController::class, "index"])->name("friends.index");
  Route::post("/friends/{receiver}/send", [App\Http\Controllers\Friends\FriendsController::class, "send"])->name("friends.send");
  Route::post("/friends/{sender}/accept", [App\Http\Controllers\Friends\FriendsController::class, "accept"])->name("friends.accept");
  Route::post("/friends/{sender}/decline", [App\Http\Controllers\Friends\FriendsController::class, "decline"])->name("friends.decline");
  Route::post("/friends/{friend}/unfriend", [App\Http\Controllers\Friends\FriendsController::class, "unfriend"])->name("friends.unfriend");
  Route::post("/friends/{receiver}/cancel", [App\Http\Controllers\Friends\FriendsController::class, "cancel"])->name("friends.cancel");

  Route::post("/follow/{user}/toggle", [App\Http\Controllers\Follow\FollowController::class, "toggle"])->name("follow.toggle");

  Route::get("/settings", [App\Http\Controllers\Settings\SettingsController::class, "index"])->name("settings.index");
  Route::put("/settings/profile", [App\Http\Controllers\Settings\SettingsController::class, "updateProfile"])->name("settings.profile");
  Route::put("/settings/about", [App\Http\Controllers\Settings\SettingsController::class, "updateAbout"])->name("settings.about");
  Route::put("/settings/password", [App\Http\Controllers\Settings\SettingsController::class, "updatePassword"])->name("settings.password");
  Route::put("/settings/privacy", [App\Http\Controllers\Settings\SettingsController::class, "updatePrivacy"])->name("settings.privacy");

  Route::post("/settings/work-experiences", [App\Http\Controllers\Settings\SettingsController::class, "storeWorkExperience"])->name("settings.work-experiences.store");
  Route::put("/settings/work-experiences/{workExperience}", [App\Http\Controllers\Settings\SettingsController::class, "updateWorkExperience"])->name("settings.work-experiences.update");
  Route::delete("/settings/work-experiences/{workExperience}", [App\Http\Controllers\Settings\SettingsController::class, "destroyWorkExperience"])->name("settings.work-experiences.destroy");

  Route::post("/settings/academic-experiences", [App\Http\Controllers\Settings\SettingsController::class, "storeAcademicExperience"])->name("settings.academic-experiences.store");
  Route::put("/settings/academic-experiences/{academicExperience}", [App\Http\Controllers\Settings\SettingsController::class, "updateAcademicExperience"])->name("settings.academic-experiences.update");
  Route::delete("/settings/academic-experiences/{academicExperience}", [App\Http\Controllers\Settings\SettingsController::class, "destroyAcademicExperience"])->name("settings.academic-experiences.destroy");

  Route::post("/settings/dating-histories", [App\Http\Controllers\Settings\SettingsController::class, "storeDatingHistory"])->name("settings.dating-histories.store");
  Route::put("/settings/dating-histories/{datingHistory}", [App\Http\Controllers\Settings\SettingsController::class, "updateDatingHistory"])->name("settings.dating-histories.update");
  Route::delete("/settings/dating-histories/{datingHistory}", [App\Http\Controllers\Settings\SettingsController::class, "destroyDatingHistory"])->name("settings.dating-histories.destroy");

  Route::get("/notifications", [App\Http\Controllers\Notification\NotificationController::class, "index"])->name("notifications.index");
  Route::post("/notifications/read-all", [App\Http\Controllers\Notification\NotificationController::class, "markAllAsRead"])->name("notifications.readAll");
  Route::post("/notifications/{notification}/read", [App\Http\Controllers\Notification\NotificationController::class, "markAsRead"])->name("notifications.read");
});
