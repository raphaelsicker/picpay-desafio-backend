<?php

namespace Tests\Unit\Notification;

use App\Jobs\SendNotification;
use App\Jobs\TransferAuthorize;
use App\Models\Notification;
use App\Models\Transfer;
use App\Repositories\Fake\FakeNotificationSenderFailRepository;
use App\Repositories\Fake\FakeNotificationSenderOkRepository;
use App\Repositories\Fake\FakeTransferAuthorizationFailRepository;
use App\Repositories\Fake\FakeTransferAuthorizationOkRepository;
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;

class SendNotificationTest extends TestCase
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

        $notification = Notification::withoutEvents(function () use ($transfer) {
            return Notification::query()->create([
                'transfer_id' => $transfer->id,
                'status' => 'pending'
            ]);
        });

        SendNotification::dispatch($notification, new FakeNotificationSenderOkRepository());

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'status' => 'sent'
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

        $notification = Notification::withoutEvents(function () use ($transfer) {
            return Notification::query()->create([
                'transfer_id' => $transfer->id,
                'status' => 'pending'
            ]);
        });

        SendNotification::dispatch($notification, new FakeNotificationSenderFailRepository());

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'status' => 'canceled'
        ]);
    }
}
