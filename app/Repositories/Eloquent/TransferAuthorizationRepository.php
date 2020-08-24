<?php


namespace App\Repositories\Eloquent;


use App\Models\Transfer;
use App\Repositories\Contracts\TransferAuthorizationRepositoryContract;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class TransferAuthorizationRepository implements TransferAuthorizationRepositoryContract
{
    public const AUTHORIZER_URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    public function ask(Transfer $transfer): array
    {
        try {
            $reponse = Http::get(self::AUTHORIZER_URL);
            return ['message' => $reponse['message'] ?? ''];
        } catch (Exception | Throwable $e) {
            return [];
        }
    }
}
