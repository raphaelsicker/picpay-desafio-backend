<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationSenderRepositoryContract;
use App\Services\Applications\NotificationSenderService;
use App\Services\Contracts\NotificationSenderServiceContract;
use App\Services\Contracts\NotificationServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var NotificationSenderServiceContract
     */
    private $notificationSenderService;

    /**
     * @var Notification
     */
    private $notification;

    /**
     * @var NotificationServiceContract
     */
    private $notificationService;

    /**
     * Create a new job instance.
     *
     * @param Notification $notification
     * @param NotificationSenderRepositoryContract|null $notificationSenderRepositoryContract
     */
    public function __construct(
        Notification $notification,
        NotificationSenderRepositoryContract $notificationSenderRepositoryContract = null
    ) {
        $this->notification = $notification;
        $this->notificationService = app(NotificationServiceContract::class);

        $this->notificationSenderService = $notificationSenderRepositoryContract
            ? new NotificationSenderService($notificationSenderRepositoryContract)
            : app(NotificationSenderServiceContract::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $authorized = $this->notificationSenderService->send($this->notification);

        if($authorized) {
            $this->notificationService->check($this->notification->id);
            return;
        }

        $this->notificationService->cancel($this->notification->id);
    }
}
