<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserNotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $notifications = $user->notifications()->latest()->take(5)->get();
            $unreadNotificationsCount = $user->unreadNotifications()->count();

            $view->with('userNotifications', $notifications)
                 ->with('unreadUserNotificationsCount', $unreadNotificationsCount);
        } else {
            $view->with('userNotifications', collect())
                 ->with('unreadUserNotificationsCount', 0);
        }
    }
}
