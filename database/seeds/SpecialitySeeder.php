<?php

use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialities')->insert([
            ['name' => 'geographer',],
            ['name' => 'accountant',],
            ['name' => 'gas engineer',],
            ['name' => 'geologist',],
            ['name' => 'actuary',],
            ['name' => 'industry engineer',],
            ['name' => 'geophysicist',],
            ['name' => 'agriculturalist',],
            ['name' => 'mechanical engineer'],
            ['name' => 'governance',],
            ['name' => 'agronomist',],
            ['name' => 'petroleum engineer',],
            ['name' => 'health',],
            ['name' => 'architect',],
            ['name' => 'rural engineer',],
            ['name' => 'information sciences',],
            ['name' => 'audit',],
            ['name' => 'telecom engineer',],
            ['name' => 'lawyer',],
            ['name' => 'biologist',],
            ['name' => 'environmental',],
            ['name' => 'livestock',],
            ['name' => 'construction',],
            ['name' => 'finance',],
            ['name' => 'management and institutions development',],
            ['name' => 'chemist forestry',],
            ['name' => 'multimedia',],
            ['name' => 'communication',],
            ['name' => 'financial analyst',],
            ['name' => 'operation and maintenance/optimization',],
            ['name' => 'computer information',],
            ['name' => 'financial management',],
            ['name' => 'population',],
            ['name' => 'electrical engineer',],
            ['name' => 'fisheries',],
            ['name' => 'logistician']
        ]);
    }
}
