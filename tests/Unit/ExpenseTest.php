<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Expense;

class ExpenseTest extends TestCase
{
    /**
     * Test validation for required fields.
     *
     * @method POST
     * @return void
     */
    public function testRequiredFieldsForExpenseCreation()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($user, 'api')->json('POST', 'api/expenses', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "amount"    => ["The amount field is required."]
                ]
            ]);
    }

    /**
     * Test creating expense.
     *
     * @method POST
     * @return void
     */
    public function testExpenseCreation()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $credentials = [
            "amount" => 100.10,
        ];

        $this->actingAs($user, 'api')->json('POST', 'api/expenses', $credentials, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "success" => [
                    'id' => 1,
                    'amount' => 100.10,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => [
                            'id'   => Role::ROLE_ADMIN,
                            'name' => Role::find(Role::ROLE_ADMIN)->name
                        ]
                    ]
                ],
            ]);
    }

    /**
     * Test validation for required fields.
     *
     * @method PUT
     * @return void
     */
    public function testRequiredFieldsForExpenseUpdation()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($user, 'api')->json('PUT', 'api/expenses/'.$user->id, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "amount"    => ["The amount field is required."]
                ]
            ]);
    }

    /**
     * Test updating expense.
     *
     * @method PUT
     * @return void
     */
    public function testExpenseUpdation()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api');

        $expense = Expense::factory()->create([
            'amount' => 100.10
        ]);

        $credentials = ["amount" => 11100.10];

        $this->json('PUT', 'api/expenses/'.$expense->id, $credentials, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                    'id' => $expense->id,
                    'amount' => $credentials["amount"],
                    'user' => [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'role' => [
                            'id'   => Role::ROLE_ADMIN,
                            'name' => Role::find(Role::ROLE_ADMIN)->name
                        ]
                    ]
                ],
            ]);
    }

    /**
     * Test deleting expense.
     *
     * @method DELETE
     * @return void
     */
    public function testExpenseDeletion()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api');

        $expense = Expense::factory()->create([
            'amount' => 100.10
        ]);

        $this->json('DELETE', 'api/expenses/'.$expense->id, ['Accept' => 'application/json'])
            ->assertStatus(204)
            ->assertNoContent();
    }

    /**
     * Test listing expense.
     *
     * @method GET
     * @return void
     */
    public function testExpensesListing()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api');

        $expenses = Expense::factory()->createMany([
            ['amount' => 100.10],
            ['amount' => 200.20],
        ]);

        $this->actingAs($admin, 'api')->json('GET', 'api/expenses', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                    "current_page" => 1,
                    'data' => [
                        [
                            'id' => $expenses[0]->id,
                            'amount' =>  $expenses[0]->amount,
                            'user' => [
                                'id' => $admin->id,
                                'name' => $admin->name,
                                'email' => $admin->email,
                                'role' => [
                                    'id'   => Role::ROLE_ADMIN,
                                    'name' => Role::find(Role::ROLE_ADMIN)->name
                                ]
                            ]
                        ],
                        [
                            'id' => $expenses[1]->id,
                            'amount' => $expenses[1]->amount,
                            'user' => [
                                'id' => $admin->id,
                                'name' => $admin->name,
                                'email' => $admin->email,
                                'role' => [
                                    'id'   => Role::ROLE_ADMIN,
                                    'name' => Role::find(Role::ROLE_ADMIN)->name
                                ]
                            ]
                        ],
                    ],
                    "last_page" => 1,
                    "from" => 1
                ],
            ]);
    }

    /**
     * Test expenses listing.
     *
     * @method GET
     * @return void
     */
    public function testExpenseListing()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api');

        $expense = Expense::factory()->create([
            'amount' => 100.10
        ]);

        $this->actingAs($admin, 'api')->json('GET', 'api/expenses/'.$expense->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                    'id' => $expense->id,
                    'amount' => $expense->amount,
                    'user' => [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'role' => [
                            'id'   => Role::ROLE_ADMIN,
                            'name' => Role::find(Role::ROLE_ADMIN)->name
                        ]
                    ]
                ],
            ]);
    }
}
