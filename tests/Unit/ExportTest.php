<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class ExportTest extends TestCase
{
    /**
     * Test successful export.
     *
     * @method POST
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
            'password' => '111111',
            'email'    => 'test@gmail.com',
            'name'     => 'Test',
            'role_id'  => Role::ROLE_ADMIN
        ]);

        $this->actingAs($user, 'api')->json('POST', 'api/export-expenses', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
