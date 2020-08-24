<?php

namespace App\Listeners;

use App\Events\CancelUsersTransferEvent;
use App\Events\ProcessUsersTransferEvent;
use App\Services\Contracts\UserTransferServiceContract;;

class CancelUsersTransferListener
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
     * @param CancelUsersTransferEvent $event
     * @return void
     */
    public function handle(CancelUsersTransferEvent $event)
    {
        $this->userTransferService->revert($event->transfer->toArray());
    }
}
