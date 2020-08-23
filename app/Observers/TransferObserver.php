<?php

namespace App\Observers;

use App\Events\CancelUsersTransferEvent;
use App\Events\FinishUsersTransferEvent;
use App\Events\ProcessUsersTransferEvent;
use App\Jobs\TransferAuthorize;
use App\Models\Transfer;

class TransferObserver
{
    /**
     * Handle the transfer "created" event.
     *
     * @param Transfer $transfer
     * @return void
     */
    public function created(Transfer $transfer)
    {
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

    /**
     * Handle the transfer "deleted" event.
     *
     * @param  Transfer  $transfer
     * @return void
     */
    public function deleted(Transfer $transfer)
    {
        //
    }

    /**
     * Handle the transfer "restored" event.
     *
     * @param  Transfer  $transfer
     * @return void
     */
    public function restored(Transfer $transfer)
    {
        //
    }

    /**
     * Handle the transfer "force deleted" event.
     *
     * @param  Transfer  $transfer
     * @return void
     */
    public function forceDeleted(Transfer $transfer)
    {
        //
    }
}
