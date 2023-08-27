<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/register', [
            "username" => "test",
            "password" => "test123",
            "name" => "test",
        ])
        ->assertStatus(201)
        ->assertJson([
            "code" => 201,
            "status" => "Created",
            "data" => [
                "username" => "test",
                "name" => "test"
            ]
        ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/register', [
            "username" => "",
            "password" => "",
            "name" => "",
        ])
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "Bad Request",
            "errors" => [
                "username" => ["The username field is required."],
                "password" => ["The password field is required."],
                "name" => ["The name field is required."]
            ]
        ]);

        $this->post('/api/register', [
            "username" => 123,
            "password" => 123,
            "name" => 123,
        ])
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "Bad Request",
            "errors" => [
                "username" => ["The username field must be a string."],
                "password" => ["The password field must be a string."],
                "name" => ["The name field must be a string."]
            ]
        ]);

        $this->seed([UserSeeder::class]);

        $this->post('/api/register', [
            "username" => "test",
            "password" => "test123",
            "name" => "test",
        ])
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "Bad Request",
            "errors" => [
                "username" => ["The username has already been taken."]
            ]
        ]);
    }

    public function testLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/login', [
            "username" => "test",
            "password" => "test123"
        ])
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK",
            "data" => [
                "username" => "test",
                "name" => "test"
            ]
        ]);
        $user = User::where("username", "test")->first();
        $this->assertNotNull($user->token);
    }

    public function testLoginFailed()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/login', [
            "username" => "",
            "password" => ""
        ])
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "Bad Request",
            "errors" => [
                "username" => ["The username field is required."],
                "password" => ["The password field is required."]
            ]
        ]);
        $this->post('/api/login', [
            "username" => 123,
            "password" => 123
        ])
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "Bad Request",
            "errors" => [
                "username" => ["The username field must be a string."],
                "password" => ["The password field must be a string."]
            ]
        ]);
    }
}
