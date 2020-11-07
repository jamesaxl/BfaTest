<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $path = 'database/scripts/cities.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('City table seeded!');
    }
}
