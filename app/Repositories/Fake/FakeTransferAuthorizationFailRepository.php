<?php


namespace App\Repositories\Fake;


use App\Models\Transfer;
use App\Repositories\Contracts\TransferAuthorizationRepositoryContract;

class FakeTransferAuthorizationFailRepository implements TransferAuthorizationRepositoryContract
{
    public function ask(Transfer $transfer): array
    {
        return ['message' => 'Falhou'];
    }
}
