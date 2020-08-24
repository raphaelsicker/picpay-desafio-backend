<?php


namespace App\Services\Applications;


use App\Repositories\Contracts\NotificationRepositoryContract;
use App\Services\Contracts\NotificationServiceContract;

class NotificationService implements NotificationServiceContract
{
    /**
     * @var NotificationRepositoryContract
     */
    private $notificationRepository;

    /**
     * NotificationService constructor.
     * @param NotificationRepositoryContract $notificationRepositoryContract
     */
    public function __construct(NotificationRepositoryContract $notificationRepositoryContract)
    {
        $this->notificationRepository = $notificationRepositoryContract;
    }

    public function all(bool $paginated = true): array
    {
        return $this->notificationRepository->all($paginated);
    }

    public function save(array $data): array
    {
        return $this->notificationRepository->save($data);
    }

    public function find(int $id): array
    {
        return $this->notificationRepository->find($id);
    }

    public function update(array $data, int $id): array
    {
        return $this->notificationRepository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        return $this->notificationRepository->delete($id);
    }

    public function check(int $id): array
    {
        return $this->notificationRepository->check($id);
    }

    public function cancel(int $id): array
    {
        return $this->notificationRepository->cancel($id);
    }
}
