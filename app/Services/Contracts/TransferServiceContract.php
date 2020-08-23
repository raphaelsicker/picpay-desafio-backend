<?php

namespace App\Services\Contracts;

interface TransferServiceContract
{
    public function make($payerId, $payeeId, $value);
    public function transferProcessed($transferId);
}
