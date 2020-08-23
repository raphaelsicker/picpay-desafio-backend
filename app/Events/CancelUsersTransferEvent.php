<?php

namespace App\Events;

use App\Models\Transfer;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelUsersTransferEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Transfer
     */
    public $transfer;

    /**
     * Create a new event instance.
     *
     * @param Transfer $transfer
     */
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }
}
