<?php


namespace App\Repositories\Eloquent;


use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryContract;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class NotificationRepository implements NotificationRepositoryContract
{

    /**
     * @var Builder | Notification
     */
    private $model;

    public function __construct(Notification $notification)
    {
        $this->model = $notification;
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
        if($notification = $this->model->find($id)) {
            $notification->fill($data);
            $notification->save();

            return $notification->toArray();
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

    public function check(int $id): array
    {
        $data = ['status' => $this->model::STATUS_SENT];
        return $this->update($data, $id);
    }

    public function cancel(int $id): array
    {
        $data = ['status' => $this->model::STATUS_CANCELED];
        return $this->update($data, $id);
    }
}
