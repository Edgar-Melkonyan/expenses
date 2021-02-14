<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password        = env('APP_ENV') == 'prod' ? 'dclmqdgg' : 111111;
        $currentDatetime = now();

        DB::table('users')->delete();
        DB::table('oauth_clients')->delete();

        DB::table('users')->insert([
            [
                'id'         => 1,
                'name'       => 'Administrator',
                'email'      => 'admin@gmail.com',
                'role_id'    => Role::ROLE_ADMIN,
                'password'   => bcrypt($password),
                'created_at' => $currentDatetime,
                'updated_at' => $currentDatetime
            ]
        ]);

        DB::table('oauth_clients')->insert([
            [
                'id'                     => 1,
                'name'                   => 'MyApp',
                'secret'                 => 'A66VpwgHGmFQMDW70Pe4k7WgD7fbXHZTtWBu79lG',
                'personal_access_client' => 1,
                'password_client'        => 1,
                'redirect'               => '/',
                'revoked'                => false,
                'created_at'             => $currentDatetime,
                'updated_at'             => $currentDatetime,
            ]
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            [
                'client_id'  => 1,
                'created_at' => $currentDatetime,
                'updated_at' => $currentDatetime,
            ],
        ]);

    }
}