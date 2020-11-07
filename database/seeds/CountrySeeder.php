<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $path = 'database/scripts/countries.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Country table seeded!');

    }
}
