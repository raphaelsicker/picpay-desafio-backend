<?php

namespace App\Observers;

use App\Events\CancelUsersTransferEvent;
use App\Events\FinishUsersTransferEvent;
use App\Events\ProcessUsersTransferEvent;
use App\Jobs\TransferAuthorize;
use App\Models\Transfer;
use App\Repositories\Contracts\UserRepositoryContract;

class TransferObserver
{
    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the transfer "created" event.
     *
     * @param Transfer $transfer
     * @return void
     */
    public function created(Transfer $transfer)
    {
        $this->userRepository->balanceDecrement(
            $transfer->payer_id,
            $transfer->value
        );

        TransferAuthorize::dispatch($transfer);
    }

    /**
     * Handle the transfer "updated" event.
     *
     * @param  Transfer  $transfer
     * @return void
     */
    public function updated(Transfer $transfer)
    {
        if($transfer->authorizedNow()) {
            event(new ProcessUsersTransferEvent($transfer));
            return;
        }

        if($transfer->canceledNow()) {
            event(new CancelUsersTransferEvent($transfer));
            return;
        }

        if($transfer->finishedNow()) {
            event(new FinishUsersTransferEvent($transfer));
        }
    }
}
