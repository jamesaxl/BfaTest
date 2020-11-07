<?php

use Illuminate\Database\Seeder;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $path = 'database/scripts/continents.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Continent table seeded!');
    }
}
