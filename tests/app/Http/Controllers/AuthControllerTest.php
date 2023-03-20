<?php

namespace Tests\app\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    //checando se os providers que esta retornando é o que queremos

    public function testReturnsWrongProvider () // teste retorna provedor errado
    {

        $payload = [
            'email' => 'paulo@dev.com.br',
            'password' => 'dev2025',
        ];


        $response = $this->post(route('authenticate', ['provider' => 'deixa o sub']), $payload);
        $responseData = json_decode($response->getContent(), true);
        $response->assertStatus(422);
        $this->assertEquals( "Provider not found", $responseData[0]['errors']['main']);
    }

    public function testUserShouldBeDeniedNotRegistered () // usuário de teste deve ser negado não registrado
    {
        $payload = [
            'email' => 'paulo@dev.com.br',
            'password' => 'dev2025',
        ];

        $response = $this->post(route('authenticate', ['provider' => 'retailer']), $payload);

        $responseData = json_decode($response->getContent(), true);
        $response->assertStatus(401);
        $this->assertEquals( "Wrong credentials", $responseData[0]['errors']['main']);
    }

    public function testUserShouldSendWrongPassword () // usuário de teste deve enviar senha errada
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'test123',
        ];

        $response = $this->post(route('authenticate', ['provider' => 'user']), $payload);
        $responseData = json_decode($response->getContent(), true);
        $response->assertStatus(401);
        $this->assertEquals( "Wrong credentials", $responseData[0]['errors']['main']);
    }

    public function testUserCanAuthenticate () // teste O usuário pode autenticar
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => 'dev2025'
        ];
        $response = $this->post(route('authenticate', ['provider' => 'user']), $payload);
        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'expires_at', 'provider']);
    }
}