<?php


namespace App\Repositories\Contracts;


use App\Models\Notification;

interface NotificationSenderRepositoryContract
{
    public function ask(Notification $notification): array;
}
