<?php

namespace App\Listeners;

use App\Events\ReportSubmitted;
use App\Models\User;
use App\Notifications\NewReportSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewReportNotificationToAdmins implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(ReportSubmitted $event): void
    {
        $admins = User::whereIn('role', ['admin', 'global_admin'])->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewReportSubmitted($event->report));
        }
    }
}
