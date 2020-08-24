<?php

namespace Tests\Feature\User;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserCRUDTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllUsers()
    {
        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
    }

    /**
     * @dataProvider usersProvider
     * @param string $name
     * @param string $cpf
     * @param string $email
     * @param string $password
     */
    public function testSaveUser(
        string $name,
        string $cpf,
        string $email,
        string $password
    ): void {
        $this->withoutNotifications();

        DB::beginTransaction();

        $response = $this->postJson(
            route('user.store'),
            [
                'name' => $name,
                'cpf' => $cpf,
                'email' => $email,
                'password' => $password
            ]
        );

        $response->assertCreated();
        DB::rollBack();
    }

    public function testUpdateUser()
    {
        $this->withoutNotifications();

        DB::beginTransaction();

        $usuarios = $this->usersProvider();

        $response = $this->postJson(
            route('user.store'),
            $usuarios[0]
        );

        $response->assertCreated();
        self::assertEquals('Maria', $response['name']);

        $createdUserId = $response['id'];

        $response = $this->putJson(
            route('user.update', ['user' => $createdUserId]),
            $usuarios[1]
        );

        $response->assertCreated();
        self::assertEquals($createdUserId, $response['id']);
        self::assertEquals('João', $response['name']);

        DB::rollBack();
    }

    public function testDeleteUser()
    {
        $this->withoutNotifications();

        DB::beginTransaction();
        $usuarios = $this->usersProvider();

        $response = $this->postJson(
            route('user.store'),
            $usuarios[0]
        );

        $response->assertCreated();
        $createdUserId = $response['id'];

        $response = $this->deleteJson(
            route('user.destroy', ['user' => $createdUserId])
        );

        $response->assertOk();

        DB::rollBack();
    }

    public function usersProvider()
    {
        return [
            [
                'name' => 'Maria',
                'cpf' => '98765432101',
                'email' => 'maria@phpunit.com',
                'password' => '123'
            ],[
                'name' => 'João',
                'cpf' => '98765432102',
                'email' => 'joao@phpunit.com',
                'password' => '987'
            ],
        ];
    }
}
