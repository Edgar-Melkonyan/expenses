<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            [
                'id'         => Role::ROLE_ADMIN,
                'name'       => 'Administrator'
            ],
            [
                'id'         => Role::ROLE_USER,
                'name'       => 'User'
            ]
        ]);
    }
}