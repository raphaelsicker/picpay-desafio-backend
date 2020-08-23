<?php

namespace App\Observers;

use App\Jobs\GetAuthorization;
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
        GetAuthorization::dispatch();
        dd($transfer);
    }

    /**
     * Handle the transfer "updated" event.
     *
     * @param  Transfer  $transfer
     * @return void
     */
    public function updated(Transfer $transfer)
    {
        //
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
