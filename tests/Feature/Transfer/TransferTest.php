<?php

namespace Tests\Feature\Transfer;

use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransferCRUDTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllTransfers()
    {
        $response = $this->get(route('transfer.index'));
        $response->assertStatus(200);
    }

    public function testValidTransfer(): void {
        $this->withoutNotifications();

        DB::beginTransaction();

        $response = $this->postJson(
            route('transfer.store'),
            [
                'payer_id' => 1,
                'payee_id' => 2,
                'value' => 100.00,
            ]
        );

        $response->assertCreated();
        DB::rollBack();
    }

    public function testInvalidValue(): void {
        $this->withoutNotifications();

        DB::beginTransaction();

        $response = $this->postJson(
            route('transfer.store'),
            [
                'payer_id' => 1,
                'payee_id' => 2,
            ]
        );

        $response->assertStatus(422);

        $response = $this->postJson(
            route('transfer.store'),
            [
                'payer_id' => 1,
                'payee_id' => 2,
                'value' => 10000000000000000.00
            ]
        );

        $response->assertStatus(422);
        DB::rollBack();
    }

    public function testInvalidPayee(): void {
        $this->withoutNotifications();

        DB::beginTransaction();

        $response = $this->postJson(
            route('transfer.store'),
            [
                'payer_id' => 1,
                'payee_id' => 10000000000000000,
                'value' => 100.00,
            ]
        );

        $response->assertStatus(422);

        $response = $this->postJson(
            route('transfer.store'),
            [
                'payer_id' => 1,
                'payee_id' => 10000000000000000,
                'value' => 100.00,
            ]
        );

        $response->assertStatus(422);
        DB::rollBack();
    }

    public function testInvalidPayer(): void {
        $this->withoutNotifications();

        DB::beginTransaction();

        $response = $this->postJson(
            route('transfer.store'),
            [
                'payer_id' => 10000000000000000,
                'payee_id' => 2,
                'value' => 100.00,
            ]
        );

        $response->assertStatus(422);
        DB::rollBack();
    }
}
