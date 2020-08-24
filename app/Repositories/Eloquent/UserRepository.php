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

    public function balanceIncrement(int $userId, float $value): array
    {
        $user = $this->find($userId);

        return $this->update(
            ['money' => $user['money'] + $value],
            $userId
        );
    }

    public function balanceDecrement(int $userId, float $value): array
    {
        $user = $this->find($userId);

        return $this->update(
            ['money' => $user['money'] - $value],
            $userId
        );
    }

    /**
     * Usaado para a criação de um banco de dados
     * @return array[]
     */
    public function fakeUsers(): array
    {
        return [
            [
                'name' => 'Maria',
                'cpf' => '12345678901',
                'email' => 'maria@teste.com',
                'password' => '123',
                'type' => 'common',
                'money' => 1000.00
            ],[
                'name' => 'João',
                'cpf' => '12345678902',
                'email' => 'joao@teste.com',
                'password' => '987',
                'type' => 'common',
                'money' => 100.00
            ],[
                'name' => 'José',
                'cpf' => '12345678903',
                'email' => 'joao@hotmail.com',
                'password' => '456',
                'type' => 'common',
                'money' => 200.00
            ],[
                'name' => 'Rita',
                'cpf' => '12345678904',
                'email' => 'joao@gmail.com',
                'password' => '321',
                'type' => 'shopkeeper',
                'money' => 200.00
            ],[
                'name' => 'Pedro',
                'cpf' => '12345678905',
                'email' => 'pedro@outlook.com',
                'password' => '321',
                'type' => 'shopkeeper',
                'money' => 2000.00
            ],
        ];
    }

    public function isShopkeeper(int $id): bool
    {
        $user = $this->find($id);
        return $user['type'] === $this->model::TYPE_SHOPKEEPER;
    }
}
