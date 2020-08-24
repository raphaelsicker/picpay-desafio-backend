<?php

namespace App\Listeners;

use App\Events\ProcessUsersTransferEvent;
use App\Services\Contracts\UserTransferServiceContract;

class ProcessUsersTransferListener
{
    /**
     * @var UserTransferServiceContract
     */
    private $userTransferService;

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
    public function handle(ProcessUsersTransferEvent $event)
    {
        $this->userTransferService->process($event->transfer->toArray());
    }
}
