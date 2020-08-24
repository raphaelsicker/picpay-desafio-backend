<?php

namespace Tests\Feature\Notification;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class NotificationCRUDTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllNotifications()
    {
        $response = $this->get(route('notification.index'));
        $response->assertStatus(200);
    }

    public function testSaveUser(): void {
        $this->withoutExceptionHandling();

        DB::beginTransaction();

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

        $response = $this->postJson(
            route('notification.store'),
            ['transfer_id' => $transfer->id]
        );

        $response->assertCreated();
        DB::rollBack();
    }
}
