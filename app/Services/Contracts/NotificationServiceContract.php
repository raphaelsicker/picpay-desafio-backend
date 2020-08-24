<?php

namespace App\Services\Contracts;

interface NotificationServiceContract
{
    public function all(bool $paginated = true): array;
    public function save(array $data): array;
    public function find(int $id): array;
    public function update(array $data, int $id): array;
    public function delete(int $id): bool;
    public function check(int $id): array;
    public function cancel(int $id): array;
}
