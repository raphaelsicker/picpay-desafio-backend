<?php


namespace App\Services\Applications;


use App\Models\Notification;
use App\Services\Contracts\NotificationSenderServiceContract;

class NotificationSenderService implements NotificationSenderServiceContract
{
    /**
     * @var NotificationSenderServiceContract
     */
    private $notificationSenderRepository;

    public function __construct(NotificationSenderServiceContract $repository)
    {
        $this->notificationSenderRepository = $repository;
    }

    public function send(Notification $notification): bool
    {
        $response = $this->notificationSenderRepository->send($notification);

        if($response['message'] ?? false) {
            return $response['message'] === 'Enviado';
        }

        return false;
    }
}
