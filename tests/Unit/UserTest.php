<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class UserTest extends TestCase
{
    /**
     * Test validation for required fields.
     *
     * @method POST
     * @return void
     */
    public function testRequiredFieldsForUserCreation()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'test@gmail.com',
            'name'     => 'Test',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($user, 'api')->json('POST', 'api/users', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email"    => ["The email field is required."],
                    "password" => ["The password field is required."],
                    "name"     => ["The name field is required."],
                    "role_id"  => ["The role id field is required."],
                ]
            ]);
    }

    /**
     * Test creating user.
     *
     * @method POST
     * @return void
     */
    public function testUserCreation()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $credentials = [
            "email"                 => "test2@gmail.com",
            "name"                  => "Test",
            "password"              => "111111",
            "password_confirmation" => "111111",
            "role_id"               => Role::ROLE_ADMIN
        ];

        $this->actingAs($user, 'api')->json('POST', 'api/users', $credentials, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "success" => [
                    'id' => 3,
                    'name' => $credentials['name'],
                    'email' => $credentials['email'],
                    'role' => [
                        'id'   => Role::ROLE_ADMIN,
                        'name' => Role::find(Role::ROLE_ADMIN)->name
                    ]
                ],
            ]);
    }

    /**
     * Test plain user restrictions.
     *
     * @method POST
     * @return void
     */
    public function testPlainUserRestrictions()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'test@test.com',
            'name'     => 'Test',
            'role_id'  => Role::ROLE_USER
        ]);

        $this->actingAs($user, 'api')->json('GET', 'api/users', ['Accept' => 'application/json'])
            ->assertStatus(403);
    }

    /**
     * Test validation for required fields.
     *
     * @method POST
     * @return void
     */
    public function testRequiredFieldsForUserUpdation()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($user, 'api')->json('PUT', 'api/users/'.$user->id, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email"    => ["The email field is required."],
                    "name"     => ["The name field is required."],
                    "role_id"  => ["The role id field is required."],
                ]
            ]);
    }

    /**
     * Test updating user.
     *
     * @method PUT
     * @return void
     */
    public function testUserUpdation()
    {
        $admin = User::whereRoleId(Role::ROLE_ADMIN)->first();

        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $credentials = [
            "email"                 => "test2@gmail.com",
            "name"                  => "Test2",
            "password"              => "111111",
            "password_confirmation" => "111111",
            'role_id'               => Role::ROLE_ADMIN
        ];

        $this->actingAs($admin, 'api')->json('PUT', 'api/users/'.$user->id, $credentials, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                    'id' => $user->id,
                    'name' => $credentials['name'],
                    'email' => $credentials['email'],
                    'role' => [
                        'id'   => Role::ROLE_ADMIN,
                        'name' => Role::find(Role::ROLE_ADMIN)->name
                    ]
                ],
            ]);
    }

    /**
     * Test deleting user.
     *
     * @method DELETE
     * @return void
     */
    public function testUserDeletion()
    {
        $users = User::factory()->createMany([
            [
                'password' => '111111',
                'email'    => 'admin@admin.com',
                'name'     => 'Admin',
                'role_id'  => Role::ROLE_ADMIN
            ],
            [
                'password' => '111111',
                'email'    => 'test@gmail.com',
                'name'     => 'Test',
                'role_id'  => Role::ROLE_USER
            ]
        ]);

        $this->actingAs($users[0], 'api')->json('DELETE', 'api/users/'.$users[1]->id, ['Accept' => 'application/json'])
            ->assertStatus(204)
            ->assertNoContent();
    }

    /**
     * Test user restriction to delete himself.
     *
     * @method DELETE
     * @return void
     */
    public function testUserRestrictedToDeleteHimself()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'test@gmail.com',
            'name'     => 'Test',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($user, 'api')->json('DELETE', 'api/users/'.$user->id, ['Accept' => 'application/json'])
            ->assertStatus(403);
    }

    /**
     * Test users listing.
     *
     * @method GET
     * @return void
     */
    public function testUsersListing()
    {
        $users = User::factory()->createMany([
            [
                'password' => '111111',
                'email'    => 'admin@admin.com',
                'name'     => 'Admin',
                'role_id'  => Role::ROLE_ADMIN
            ],
            [
                'password' => '111111',
                'email'    => 'test@gmail.com',
                'name'     => 'Test',
                'role_id'  => Role::ROLE_USER
            ]
        ]);

        $this->actingAs($users[0], 'api')->json('GET', 'api/users', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                    "current_page" => 1,
                    'data' => [
                        [
                            'id' => 1,
                            'name' => 'Administrator',
                            'email' => 'admin@gmail.com',
                            'role' => [
                                'id'   => Role::ROLE_ADMIN,
                                'name' => Role::find(Role::ROLE_ADMIN)->name
                            ]
                        ],
                        [
                            'id' => 2,
                            'name' => $users[0]->name,
                            'email' => $users[0]->email,
                            'role' => [
                                'id'   => Role::ROLE_ADMIN,
                                'name' => Role::find(Role::ROLE_ADMIN)->name
                            ]
                        ],
                        [
                            'id' => 3,
                            'name' => $users[1]->name,
                            'email' => $users[1]->email,
                            'role' => [
                                'id'   => Role::ROLE_USER,
                                'name' => Role::find(Role::ROLE_USER)->name
                            ]
                        ],
                    ],
                    "last_page" => 1,
                    "from" => 1
                ],
            ]);
    }

    /**
     * Test listing single.
     *
     * @method GET
     * @return void
     */
    public function testUserListing()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($user, 'api')->json('GET', 'api/users/'.$user->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => [
                        'id'   => Role::ROLE_ADMIN,
                        'name' => Role::find(Role::ROLE_ADMIN)->name
                    ]
                ]
            ]);
    }
}