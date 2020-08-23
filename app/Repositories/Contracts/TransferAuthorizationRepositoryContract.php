<?php


namespace App\Repositories\Contracts;


use App\Models\Transfer;
use Illuminate\Http\Client\Response;

interface TransferAuthorizationRepositoryContract
{
    public function ask(Transfer $transfer): ?Response;
}
