<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
            [
                'type' => 'admin',
                'for' => 'bfa'
            ],
            [
                'type' => 'moderator',
                'for' => 'bfa'
            ],
            [
                'type' => 'staff',
                'for' => 'bfa'
            ],
            [
                'type' => 'employee',
                'for' => 'user'
            ]
        ]);

        DB::table('users')->insert([
                [
                    'name' => 'Mandrake Root',
                    'email' => 'admin@dev.com',
                    'password' => bcrypt('secret'),
                    'abv_gender' => 'Mr.',
                    'gender' => 'male',
                    'language_id' => 1,
                    'account_type_id' => 1, // staff
                    'is_enabled' => true,
                    'role_id' => 1,
                ],
                [
                    'name' => 'Bfa Scraper',
                    'email' => 'scraper@dev.com',
                    'password' => bcrypt('secret'),
                    'abv_gender' => 'Mr.',
                    'gender' => 'male',
                    'language_id' => 1,
                    'account_type_id' => 1,
                    'is_enabled' => true,
                    'role_id' => 2,
                ]
        ]
        );
    }
}
