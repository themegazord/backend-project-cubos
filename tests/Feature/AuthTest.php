<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $payload = [
        'name' => 'Gustavo de Camargo Campos',
        'email' => 'contato.wanjalagus@outlook.com.br',
        'password' => 'password'
    ];

    private $payloadAka = [
        'name' => 'Gustavo',
        'email' => 'email@email.com',
        'password' => 'password'
    ];

    public function test_user_registration_route_validation()
    {
        DB::delete('delete from users where email = :email', ['email'=> $this->payload['email']]);
        $response = $this->json('POST','api/auth/register', $this->payload);
        $response->assertStatus(201);
        $response->assertJson(['msg' => 'User has been created']);
    }

    public function test_user_registration_with_only_first_name() {
        DB::delete('delete from users where email = :email', ['email'=> $this->payloadAka['email']]);
        $response = $this->json('POST', 'api/auth/register', $this->payloadAka);
        $response->assertStatus(201);
        $response->assertJson(['msg' => 'User has been created']);
    }

    public function test_user_login_route_validation() {
        $response = $this->json('POST', 'api/auth/login', [
            'email' => 'contato.wanjalagus@outlook.com.br',
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'user'
        ]);
    }

    public function test_user_login_route_validation_aka_first_name() {
        $response = $this->json('POST', 'api/auth/login', [
            'email' => 'email@email.com',
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'user',
        ]);
    }


    public function test_user_inserted_invalid_credentials_at_login() {
        $response = $this->json('POST','api/auth/login', [
            'email' => 'email@email.com',
            'password' => '123',
        ]);
        $response->assertStatus(401);
        $response->assertJson(['error' => 'O email e a senha não são válidos']);
    }
}
