<?php

namespace Tests\Unit\Transfer;

use App\Jobs\TransferAuthorize;
use App\Models\Transfer;
use App\Repositories\Fake\FakeTransferAuthorizationFailRepository;
use App\Repositories\Fake\FakeTransferAuthorizationOkRepository;
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;

class TransferAuthorizatorTest extends TestCase
{
    public function testJobsOk()
    {
        /**
         * Crio uma transferencia desativando os observers.
         * @var Transfer | Builder $transfer
         */
        $transfer = Transfer::withoutEvents(function () {
            return Transfer::query()->create([
                'payer_id' => 1,
                'payee_id' => 2,
                'value' => 100,
                'status' => 'pending'
            ]);
        });

        TransferAuthorize::dispatch($transfer, new FakeTransferAuthorizationOkRepository);

        $this->assertDatabaseHas('transfers', [
            'id' => $transfer->id,
            'status' => 'finished'
        ]);
    }

    public function testJobsFail()
    {
        /**
         * Crio uma transferencia desativando os observers.
         * @var Transfer | Builder $transfer
         */
        $transfer = Transfer::withoutEvents(function () {
            return Transfer::query()->create([
                'payer_id' => 1,
                'payee_id' => 2,
                'value' => 100,
                'status' => 'pending'
            ]);
        });

        TransferAuthorize::dispatch($transfer, new FakeTransferAuthorizationFailRepository);

        $this->assertDatabaseHas('transfers', [
            'id' => $transfer->id,
            'status' => 'canceled'
        ]);
    }
}
