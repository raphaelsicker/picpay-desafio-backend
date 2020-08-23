<?php


namespace App\Services\Contracts;


use App\Models\Transfer;

interface TransferAuthorizerServiceContract
{
    public function getAuthorization(Transfer $transfer): bool;
}
