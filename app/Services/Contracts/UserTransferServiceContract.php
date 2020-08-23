<?php


namespace App\Services\Contracts;

interface UserTransferServiceContract
{
    public function process(array $transfer): bool;
    public function revert(array $transfer): bool;
    public function finish(array $transfer): bool;
}
