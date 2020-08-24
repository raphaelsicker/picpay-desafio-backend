<?php


namespace App\Services\Applications;


use App\Models\Notification;
use App\Repositories\Contracts\NotificationSenderRepositoryContract;
use App\Services\Contracts\NotificationSenderServiceContract;

class NotificationSenderService implements NotificationSenderServiceContract
{
    /**
     * @var
     */
    private $notificationSenderRepository;

    public function __construct(NotificationSenderRepositoryContract $repository)
    {
        $this->notificationSenderRepository = $repository;
    }

    public function send(Notification $notification): bool
    {
        $response = $this->notificationSenderRepository->ask($notification);

        if($response['message'] ?? false) {
            return $response['message'] === 'Enviado';
        }

        return false;
    }
}
