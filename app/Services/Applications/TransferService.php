<?php


namespace App\Services\Applications;


use App\Repositories\Contracts\TransferRepositoryContract;
use App\Services\Contracts\TransferServiceContract;

class TransferService implements TransferServiceContract
{
    /**
     * @var TransferRepositoryContract
     */
    private $transferRepository;

    /**
     * TransferService constructor.
     * @param TransferRepositoryContract $transferRepositoryContract
     */
    public function __construct(TransferRepositoryContract $transferRepositoryContract)
    {
        $this->transferRepository = $transferRepositoryContract;
    }

    public function all(bool $paginated = true): array
    {
        return $this->transferRepository->all($paginated);
    }

    public function save(array $data): array
    {
        return $this->transferRepository->save($data);
    }

    public function find($id): array
    {
        return $this->transferRepository->find($id);
    }

    public function update(array $data, int $id): array
    {
        return $this->transferRepository->update($data, $id);
    }

    public function delete($id): bool
    {
        return $this->transferRepository->delete($id);
    }

    public function make($payerId, $payeeId, $value)
    {
        // TODO: Implement make() method.
    }

    public function transferProcessed($transferId)
    {
        // TODO: Implement transferProcessed() method.
    }
}
