<?php


namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\UserRepositoryContract;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class UserRepository implements UserRepositoryContract
{
    /**
     * @var Builder | User
     */
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
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
            return $this->model->find($created->id);
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
            return $this->model->find($id);
        }

        throw new Exception('Error on update.');
    }

    public function delete($id): bool
    {
        if (!($dados = $this->model->find($id))) {
            throw new Exception('Register not found.');
        }

        if(!$dados->delete()) {
            throw new Exception('Error on remove register.');
        }

        return true;
    }
}
