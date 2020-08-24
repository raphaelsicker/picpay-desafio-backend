<?php

namespace App\Jobs;

use App\Models\Notification;
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
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        $this->notificationSenderService = app(NotificationSenderServiceContract::class);
        $this->notificationService = app(NotificationServiceContract::class);
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
        }
    }
}
