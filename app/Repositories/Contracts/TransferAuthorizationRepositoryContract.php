<?php


namespace App\Repositories\Contracts;


use App\Models\Transfer;

interface TransferAuthorizationRepositoryContract
{
    public function ask(Transfer $transfer): array;
}
