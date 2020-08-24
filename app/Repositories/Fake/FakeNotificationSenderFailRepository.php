<?php


namespace App\Repositories\Fake;


use App\Models\Notification;
use App\Repositories\Contracts\NotificationSenderRepositoryContract;

class FakeNotificationSenderFailRepository implements NotificationSenderRepositoryContract
{
    public function ask(Notification $notification): array
    {
        return ['message' => 'Falhou'];
    }
}
