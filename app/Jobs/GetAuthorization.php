<?php

namespace App\Jobs;

use App\Models\Transfer;
use App\Services\Contracts\TransferAuthorizerServiceContract;
use App\Services\Contracts\TransferServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetAuthorization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TransferAuthorizerServiceContract
     */
    private $transferAuthorizerService;

    /**
     * @var Transfer
     */
    private $transfer;

    /**
     * @var TransferServiceContract
     */
    private $transferService;

    /**
     * Create a new job instance.
     *
     * @param Transfer $transfer
     */
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
        $this->transferAuthorizerService = app(TransferAuthorizerServiceContract::class);
        $this->transferService = app(TransferServiceContract::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $authorized = $this->transferAuthorizerService->getAuthorization($this->transfer);

        if($authorized) {
            $this->transferService->approve($this->transfer->id);
        }
    }
}
