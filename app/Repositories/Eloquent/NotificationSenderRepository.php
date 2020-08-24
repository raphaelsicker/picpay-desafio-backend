<?php


namespace App\Repositories\Eloquent;


use App\Models\Notification;
use App\Repositories\Contracts\NotificationSenderRepositoryContract;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class NotificationSenderRepository implements NotificationSenderRepositoryContract
{
    public const AUTHORIZER_URL = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';

    public function ask(Notification $notification): array
    {
        try {
            $reponse = Http::get(self::AUTHORIZER_URL);
            return ['message' => $reponse['message'] ?? ''];
        } catch (Exception | Throwable $e) {
            return [];
        }
    }
}
