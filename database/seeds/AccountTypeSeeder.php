<?php

use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_types')->insert([
            [
                'name' => 'bfa',
            ],
            [
                'name' => 'company',
            ],
            [
                'name' => 'supplier',
            ],
            [
                'name' => 'government',
            ],
            [
                'name' => 'ong',
            ],
            [
                'name' => 'financial-institution',
            ],
            [
                'name' => 'investor',
            ],
            [
                'name' => 'funder',
            ],
            [
                'name' => 'consultant',
            ],
            [
                'name' => 'firm-consultant',
            ],
        ]);
    }
}
