<?php


namespace App\Repositories\Eloquent;


use App\Models\Transfer;
use App\Repositories\Contracts\TransferRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class TransferRepository implements TransferRepositoryContract
{

    /**
     * @var Builder | Transfer
     */
    private $model;

    public function __construct(Transfer $transfer)
    {
        $this->model = $transfer;
    }

    public function all(
        bool $paginated,
        ?int $perPage = null
    ): array {
        if(!$paginated) {
            return $this->model->get();
        }

        return $this->model->paginate(
            $perPage ?? $this->model->getPerPage()
        )->toArray();
    }

    public function save(array $data): array
    {
        if($created = $this->model->create($data)) {
            return $this->find($created->id);
        }

        return [];
    }

    public function find(int $id): array
    {
        if($data = $this->model->find($id)) {
            return $data->toArray();
        }

        return [];
    }

    public function update(array $data, int $id): array
    {
        $updated = $this->model
            ->where('id', $id)
            ->update($data);

        if($updated) {
            return $this->find($id);
        }

        throw new Exception('Error on update.');
    }

    public function delete(int $id): bool
    {
        if (!($dados = $this->model->find($id))) {
            throw new Exception('Register not found.');
        }

        if(!$dados->delete()) {
            throw new Exception('Error on remove register.');
        }

        return true;
    }

    public function approve(int $id): array
    {
        $data = ['status' => $this->model::STATUS_APPROVED];
        return $this->update($data, $id);
    }

    public function cancel(int $id): array
    {
        $data = ['status' => $this->model::STATUS_CANCELED];
        return $this->update($data, $id);
    }
}
