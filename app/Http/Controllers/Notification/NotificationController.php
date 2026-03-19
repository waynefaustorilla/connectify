<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Services\Notifications\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller {
  public function __construct(protected NotificationService $notificationService) {
  }

  public function index(Request $request) {
    $userId = $request->user()->id;

    $notifications = $this->notificationService->getNotifications($userId);
    $unreadCount = $this->notificationService->getUnreadCount($userId);

    return view('pages.notifications.index')
      ->with([
        'notifications' => $notifications,
        'unreadCount' => $unreadCount,
      ]);
  }

  public function markAllAsRead(Request $request) {
    $this->notificationService->markAllAsRead($request->user()->id);

    return redirect()->route('notifications.index')->with('success', 'All notifications marked as read.');
  }

  public function markAsRead(Request $request, int $notification) {
    $notif = $this->notificationService->findForUser($notification, $request->user()->id);

    if (!$notif) {
      return redirect()->route('notifications.index');
    }

    $this->notificationService->markAsRead($notification, $request->user()->id);

    $redirectUrl = match ($notif->type) {
      'like', 'comment' => $notif->notifiable_id ? route('posts.show', $notif->notifiable_id) : route('notifications.index'),
      'friend_request' => route('friends.index'),
      default => route('profile.show', $notif->sender->username),
    };

    return redirect()->to($redirectUrl);
  }
}
