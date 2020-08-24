<?php


namespace App\Repositories\Contracts;


use App\Models\Notification;
use Illuminate\Http\Client\Response;

interface NotificationSenderRepositoryContract
{
    public function ask(Notification $notification): ?Response;
}
