<?php

namespace Tests\Feature\Transfer;

use App\Models\Transfer;
use App\Models\User;
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

        $payer = User::query()->create([
            'name' => 'Maria',
            'cpf' => '22222222222',
            'email' => 'maria@testeTransfer.com',
            'password' => '222',
            'money' => '200'
        ]);

        $payee = User::query()->create([
            'name' => 'João',
            'cpf' => '33333333333',
            'email' => 'joao@testeTransfer.com',
            'password' => '333',
            'money' => '300'
        ]);

        $response = $this->postJson(
            route('transfer.store'),
            [
                'payer_id' => $payer->id,
                'payee_id' => $payee->id,
                'value' => 100.00,
            ]
        );

        $response->assertCreated();

        // Verifio o saldo do Pagador
        $this->assertDatabaseHas('users', [
            'id' => $payer->id,
            'money' => 100
        ]);

        // Verifico o saldo do Recebedor
        $this->assertDatabaseHas('users', [
            'id' => $payee->id,
            'money' => 400
        ]);

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
