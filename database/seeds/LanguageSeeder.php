<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            [
                'name' => 'english',
            ],
            [
                'name' => 'french',
            ],
            [
                'name' => 'bilingual',
            ],
        ]);
    }
}
