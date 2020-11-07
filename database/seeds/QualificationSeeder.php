<?php

use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qualifications')->insert([
            [
                'name' => 'livestock',
                'speciality_id' => '1',
            ],
            [
                'name' => 'pasture improvement',
                'speciality_id' => '2',
            ],
            [
                'name' => 'breeding & genetics',
                'speciality_id' => '3',
            ],
            [
                'name' => 'animal production',
                'speciality_id' => '4',
            ],
            [
                'name' => 'breeding & genetics-Artificial I',
                'speciality_id' => '5',
            ],
        ]);
    }
}
