<?php

namespace Tests\app\Http\Controllers;

use App\Models\Retailer;
use App\Models\User;

use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{
    public function testUserShouldBeAValidUserToTransfer() // O usuário de teste deve ser um usuário válido para transferência
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();

        $payload = [
            'provider' => 'edggf',
            'payee_id' => 'deucertoooooo',
            'amount'   => 123
        ];

       $request = $this->actingAs($user, 'users')
           ->postJson(route('postTransaction'), $payload);
        $request->assertStatus(422);

    }

    public function testRetailerShouldNotTransfer() // Varejista de teste não deve transferir
    {
        $this->artisan('passport:install');
        $user = Retailer::factory()->create();

        $payload = [
            'provider' => 'users',
            'payee_id' => 'deucertodfg',
            'amount'   => 123
        ];

        $request = $this->actingAs($user, 'retailers')
            ->post(route('postTransaction'), $payload);
        $request->assertStatus(401);

    }

    public function testUserShouldHaveMoneyToPerformSomeTransaction () // usuário de teste deve ter dinheiro para realizar alguma transação
    {
        $this->artisan('passport:install');
        $userPayer = User::factory()->create();
        $userPayed = User::factory()->create();

        $payload = [
            'provider' => 'users',
            'payee_id' => $userPayed->id,
            'amount'   => 123
        ];

        $request = $this->actingAs($userPayer, 'users')
            ->post(route('postTransaction'), $payload);
        $request->assertStatus(422);

    }

    public function testUserCanTransferMoney () // usuário de teste pode transferir dinheiro
    {
        $this->artisan('passport:install');
        $userPayer = User::factory()->create();
        $userPayer->wallet->deposit(3000);
        $userPayed = User::factory()->create();

        $payload = [
            'provider' => 'users',
            'payee_id' => $userPayed->id,
            'amount'   => 100
        ];
        $request = $this->actingAs($userPayer, 'users')
            ->post(route('postTransaction'), $payload);
        $request->assertStatus(200);

        $this->assertDatabaseHas('wallets',
       [
           'id' => $userPayer->wallet->id,
           'balance' => 2900
       ]);

        $this->assertDatabaseHas('wallets',
            [
                'id' => $userPayed->wallet->id,
                'balance' => 100
            ]);
    }
}