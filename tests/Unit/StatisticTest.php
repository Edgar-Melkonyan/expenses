<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Expense;

class StatisticTest extends TestCase
{
    /**
     * Test validation for required fields.
     *
     * @method GET
     * @return void
     */
    public function testRequiredFieldsForYearlyStatistics()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api')->json('GET', 'api/statistics/yearly', ['Accept' => 'application/json'])    ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "year"     => ["The year field is required."]
                ]
            ]);
    }

    /**
     * Test yearly statistics.
     *
     * @method GET
     * @return void
     */
    public function testYearlyStatistics()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api');

        Expense::factory()->createMany([
            ['amount' => 100.10],
            ['amount' => 200.20],
        ]);

        $this->actingAs($admin, 'api')->json('GET', 'api/statistics/yearly?year='.date("Y"), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                        [
                            'total' => "300.30",
                            'month' => date('n'),
                        ]
                    ],
            ]);
    }

    /**
     * Test validation for required fields.
     *
     * @method GET
     * @return void
     */
    public function testRequiredFieldsForMonthlyStatistics()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api')->json('GET', 'api/statistics/monthly', ['Accept' => 'application/json'])    ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "year"     => ["The year field is required."],
                    "month"    => ["The month field is required."]
                ]
            ]);
    }

    /**
     * Test monthly statistics.
     *
     * @method GET
     * @return void
     */
    public function testMonthlyStatistics()
    {
        $admin = User::factory()->create([
            'password' => '111111',
            'email'    => 'admin@admin.com',
            'name'     => 'Admin',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($admin, 'api');

        Expense::factory()->createMany([
            ['amount' => 100.10],
            ['amount' => 200.20],
        ]);

        $this->actingAs($admin, 'api')->json('GET', 'api/statistics/monthly?year='.date("Y").'&month='.date('n'), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => [
                        [
                            'total' => "300.30",
                            'day'   => date("j")
                        ]
                    ],
            ]);
    }
}
