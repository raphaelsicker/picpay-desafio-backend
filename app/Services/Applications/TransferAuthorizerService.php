<?php


namespace App\Services\Applications;


use App\Models\Transfer;
use App\Repositories\Contracts\TransferAuthorizationRepositoryContract;
use App\Services\Contracts\TransferAuthorizerServiceContract;

class TransferAuthorizerService implements TransferAuthorizerServiceContract
{
    /**
     * @var TransferAuthorizationRepositoryContract
     */
    private $transferAuthorizationRepository;

    public function __construct(TransferAuthorizationRepositoryContract $repository)
    {
        $this->transferAuthorizationRepository = $repository;
    }

    public function getAuthorization(Transfer $transfer): bool
    {
        $response = $this->transferAuthorizationRepository->ask($transfer);

        if($response['message'] ?? false) {
            return $response['message'] ==='Autorizado';
        }

        return false;
    }
}
