<?php

namespace App\Services\Contracts;

use App\Models\Notification;

interface NotificationSenderServiceContract
{
    public function send(Notification $notification): bool;
}
