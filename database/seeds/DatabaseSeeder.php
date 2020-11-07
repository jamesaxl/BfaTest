<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LanguageSeeder::class,
            CurrencySeeder::class,
            ContinentSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            SectorSeeder::class,
            AccountTypeSeeder::class,
            AccountSubTypeSeeder::class,
            SpecialitySeeder::class,
            //QualificationSeeder::class,
            UserSeeder::class,
            ProducerSeeder::class,
            DocumentTypeSeeder::class,
            DocumentSubTypeSeeder::class,
        ]);
    }
}
