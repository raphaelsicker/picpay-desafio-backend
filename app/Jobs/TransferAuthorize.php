<?php

namespace App\Jobs;

use App\Models\Transfer;
use App\Repositories\Contracts\TransferAuthorizationRepositoryContract;
use App\Services\Applications\TransferAuthorizerService;
use App\Services\Contracts\TransferAuthorizerServiceContract;
use App\Services\Contracts\TransferServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferAuthorize implements ShouldQueue
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
     * @param TransferAuthorizationRepositoryContract|null $transferAuthorizationRepositoryContract
     */
    public function __construct(
        Transfer $transfer,
        TransferAuthorizationRepositoryContract $transferAuthorizationRepositoryContract = null
    ) {
        $this->transfer = $transfer;
        $this->transferService = app(TransferServiceContract::class);

        $this->transferAuthorizerService = $transferAuthorizationRepositoryContract
            ? new TransferAuthorizerService($transferAuthorizationRepositoryContract)
            : app(TransferAuthorizerServiceContract::class);
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
            return;
        }

        $this->transferService->cancel($this->transfer->id);
    }
}
