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

        $response = $this->post(route('authentication', ['provider' => 'test']), $payload);
        $response->assertStatus(404);
        $this->assertEquals( "Provider not found", $response->getContent());
    }

    public function testUserShouldBeDeniedNotRegistered () // usuário de teste deve ser negado não registrado
    {
        $payload = [
            'email' => 'paulo@dev.com',
            'password' => 'dev25',
        ];

        $response = $this->post(route('authentication', ['provider' => 'retailer']), $payload);
        $response->assertStatus(401);
        $this->assertEquals( "Wrong credentials", $response->getContent());
    }

    public function testUserShouldSendWrongPassword () // usuário de teste deve enviar senha errada
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'test123',
        ];

        $response = $this->post(route('authentication', ['provider' => 'user']), $payload);
        $response->assertStatus(401);
        $this->assertEquals( "Wrong credentials", $response->getContent());
    }

    public function testUserCanAuthenticate () // teste O usuário pode autenticar
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => 'dev2025'
        ];

        $response = $this->post(route('authentication', ['provider' => 'user']), $payload);
        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'expires_at', 'provider']);
    }
}