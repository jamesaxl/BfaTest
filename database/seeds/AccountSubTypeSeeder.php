<?php

use Illuminate\Database\Seeder;

class AccountSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_sub_types')->insert([
            [
                'account_type_id' => 1,
                'name' => 'bfa',
            ],
            [
                'account_type_id' => 2,
                'name' => 'big business',
            ],
            [
                'account_type_id' => 2,
                'name' => 'small and medium-sized enterprise (SME)',
            ],
            [
                'account_type_id' => 2,
                'name' => 'small and Medium Industry (PMI)',
            ],
            [
                'account_type_id' => 2,
                'name' => 'start-up',
            ],
            [
                'account_type_id' => 2,
                'name' => 'developer',
            ],
            [
                'account_type_id' => 2,
                'name' => 'transporter',
            ],
            [
                'account_type_id' => 3,
                'name' => 'start-up',
            ],
            [
                'account_type_id' => 3,
                'name' => 'big supplier',
            ],
            [
                'account_type_id' => 3,
                'name' => 'small-medium supplier',
            ],
            [
                'account_type_id' => 4,
                'name' => 'government',
            ],
            [
                'account_type_id' => 4,
                'name' => 'public company',
            ],
            [
                'account_type_id' => 5,
                'name' => 'non governmental organization',
            ],
            [
                'account_type_id' => 5,
                'name' => 'civil society',
            ],
            [
                'account_type_id' => 6,
                'name' => 'public Bank',
            ],
            [
                'account_type_id' => 6,
                'name' => 'private banking',
            ],
            [
                'account_type_id' => 6,
                'name' => 'micro finance',
            ],
            [
                'account_type_id' => 6,
                'name' => 'micro credit',
            ],
            [
                'account_type_id' => 6,
                'name' => 'insurance',
            ],

            [
                'account_type_id' => 7,
                'name' => 'private',
            ],
            [
                'account_type_id' => 7,
                'name' => 'investment Funds',
            ],
            [
                'account_type_id' => 7,
                'name' => 'pension funds',
            ],
            [
                'account_type_id' => 7,
                'name' => 'sovereign Funds',
            ],

            [
                'account_type_id' => 8,
                'name' => 'multilateral',
            ],
            [
                'account_type_id' => 8,
                'name' => 'bilateral',
            ],
            [
                'account_type_id' => 9,
                'name' => 'consultant',
            ],
            [
                'account_type_id' => 10,
                'name' => 'firm consultant',
            ],
        ]);
    }
}
