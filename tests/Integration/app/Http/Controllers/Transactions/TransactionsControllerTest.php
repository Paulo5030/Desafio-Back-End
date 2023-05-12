<?php

namespace Integration\app\Http\Controllers\Transactions;

use App\Models\Retailer;
use App\Models\User;
use Fig\Http\Message\StatusCodeInterface;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    //O usuário de teste deve ser um usuário válido para transferir
    public function testUserShouldBeAValidUserToTransfer()
    {
        $user = User::factory()->create();

        $payload = [
            'provider' => 'User',
            'payee_id' => 'deuo',
            'amount'   => 123
        ];
        $request = $this->actingAs($user, 'users')
            ->postJson(route('postTransaction'), $payload);
        $request->assertStatus(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
    }
    public function testRetailerShouldNotTransfer() // Varejista de teste não deve transferir
    {
        $user = Retailer::factory()->create();

        $payload = [
            'provider' => 'user',
            'payee_id' => 'deucertodfg',
            'amount'   => 123
        ];

        $request = $this->actingAs($user, 'retailers')
            ->post(route('postTransaction'), $payload);

        $request->assertStatus(StatusCodeInterface::STATUS_UNAUTHORIZED);
    }

    //usuário de teste deve ter dinheiro para realizar alguma transação
    public function testUserShouldHaveMoneyToPerformSomeTransaction()
    {
        $userPayer = User::factory()->create();
        $userPayed = User::factory()->create();

        $payload = [
            'provider' => 'user',
            'payee_id' => $userPayed->id,
            'amount'   => 123
        ];

        $request = $this->actingAs($userPayer, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertStatus(StatusCodeInterface::STATUS_FORBIDDEN);
    }

    public function testUserCanTransferMoney() // usuário de teste pode transferir dinheiro
    {
        $userPayer = User::factory()->create();
        $userPayer->wallet->deposit(3000);
        $userPayed = User::factory()->create();

        $payload = [
            'provider' => 'user',
            'payee_id' => $userPayed->id,
            'amount'   => 100
        ];

        $request = $this->actingAs($userPayer, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertStatus(StatusCodeInterface::STATUS_OK);

        $this->assertDatabaseHas(
            'wallets',
            [
                'id' => $userPayer->wallet->id,
                'balance' => 2900
            ]
        );

        $this->assertDatabaseHas(
            'wallets',
            [
                'id' => $userPayed->wallet->id,
                'balance' => 100
            ]
        );
    }
}
