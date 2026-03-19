<?php

namespace App\Providers;

use App\Services\Notifications\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
  /**
   * Register any application services.
   */
  public function register(): void {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void {
    View::composer('*', function ($view) {
      if (Auth::check()) {
        $notificationService = app(NotificationService::class);
        $view->with('notificationUnreadCount', $notificationService->getUnreadCount(Auth::id()));
      }
    });
  }
}
