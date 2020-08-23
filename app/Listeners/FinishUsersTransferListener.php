<?php

namespace App\Listeners;

use App\Events\FinishUsersTransferEvent;
use App\Events\ProcessUsersTransferEvent;
use App\Services\Contracts\UserTransferServiceContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FinishUsersTransferListener
{
    /**
     * Create the event listener.
     *
     * @param UserTransferServiceContract $userTransferService
     */
    public function __construct(UserTransferServiceContract $userTransferService)
    {
        $this->userTransferService = $userTransferService;
    }

    /**
     * Handle the event.
     *
     * @param ProcessUsersTransferEvent $event
     * @return void
     */
    public function handle(FinishUsersTransferEvent $event)
    {
        $this->userTransferService->finish($event->transfer->toArray());
    }
}
