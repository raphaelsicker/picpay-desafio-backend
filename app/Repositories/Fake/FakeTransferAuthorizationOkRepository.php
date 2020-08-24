<?php


namespace App\Repositories\Fake;


use App\Models\Transfer;
use App\Repositories\Contracts\TransferAuthorizationRepositoryContract;

class FakeTransferAuthorizationOkRepository implements TransferAuthorizationRepositoryContract
{
    public function ask(Transfer $transfer): array
    {
        return ['message' => 'Autorizado'];
    }
}
