<?php

namespace App\Observers;

use App\Events\CancelUsersNotificationEvent;
use App\Events\FinishUsersNotificationEvent;
use App\Events\ProcessUsersNotificationEvent;
use App\Jobs\NotificationAuthorize;
use App\Jobs\SendNotification;
use App\Models\Notification;

class NotificationObserver
{
    /**
     * Handle the notification "created" event.
     *
     * @param Notification $notification
     * @return void
     */
    public function created(Notification $notification)
    {
        SendNotification::dispatch($notification);
    }
}
