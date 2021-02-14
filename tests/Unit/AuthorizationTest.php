<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class AuthorizationTest extends TestCase
{
    /**
     * Test validation for required fields.
     *
     * @method POST
     * @return void
     */
    public function testRequiredFieldsForLogin()
    {
        $this->json('POST', 'api/login', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email"    => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    /**
     * Test successful login.
     *
     * @method POST
     * @return void
     */
    public function testSuccessfulLogin()
    {
        User::factory()->create([
            'password' => '111111',
            'email'    => 'test@gmail.com',
            'name'     => 'Test',
            'role_id'  => Role::ROLE_ADMIN
        ]);
     
        $credentials = [
            "email"    => "test@gmail.com",
            "password" => "111111",
        ];

        $this->json('POST', 'api/login', $credentials, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success" => [
                    'token',
                ],
            ]);
    }
}
