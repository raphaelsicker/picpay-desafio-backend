<?php

namespace App\Observers;

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
