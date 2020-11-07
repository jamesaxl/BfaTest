<?php

use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('sectors')->insert([
            [
                'name' => 'Agriculture and Rural Development',
            ],
            [
                'name' => 'Environment',
            ],
            [
                'name' => 'Industry, Mining & Quarrying',
            ],
            [
                'name' => 'Multi-Sector',
            ],
            [
                'name' => 'Power',
            ],
            [
                'name' => 'Social',
            ],
            [
                'name' => 'Transport',
            ],
            [
                'name' => 'Water supply and Sanitation',
            ],
        ]);

        DB::table('sub_sectors')->insert([
            [
                'name' => 'Agriculture',
                'sector_id' => 1,
            ],
            [
                'name' => 'Cash Crops',
                'sector_id' => 1,
            ],
            [
                'name' => 'Food Crops',
                'sector_id' => 1,
            ],
            [
                'name' => 'Irrigation And Drainage',
                'sector_id' => 1,
            ],
            [
                'name' => 'Forestry / Plantations',
                'sector_id' => 1,
            ],
            [
                'name' => 'Livestock',
                'sector_id' => 1,
            ],
            [
                'name' => 'Fisheries / Maritime Food',
                'sector_id' => 1,
            ],
            [
                'name' => 'Agro-Industry',
                'sector_id' => 1,
            ],
            [
                'name' => 'More Than One Agricultural Sub-Sector',
                'sector_id' => 1,
            ],
            [
                'name' => 'Rural Development',
                'sector_id' => 1,
            ],
            [
                'name' => 'More Than One Agri.& Rural Development Sub-Sector',
                'sector_id' => 1,
            ],
            [
                'name' => 'Atmospheric Pollution',
                'sector_id' => 2,
            ],            [
                'name' => 'Water Pollution',
                'sector_id' => 2,
            ],
            [
                'name' => 'Mining & Quarrying',
                'sector_id' => 3,
            ],
            [
                'name' => 'Mining',
                'sector_id' => 3,
            ]
            ,
            [
                'name' => 'Quarrying',
                'sector_id' => 3,
            ],
            [
                'name' => 'Manufacturing',
                'sector_id' => 3,
            ],
            [
                'name' => 'Tourism',
                'sector_id' => 3,
            ],
            [
                'name' => 'Public Sector Management',
                'sector_id' => 4,
            ],
            [
                'name' => 'Private Sector Management',
                'sector_id' => 4,
            ],
            [
                'name' => 'Industrial Import',
                'sector_id' => 4,
            ],
            [
                'name' => 'Export Promotion',
                'sector_id' => 4,
            ],
            [
                'name' => 'Infrastructure',
                'sector_id' => 4,
            ],
            [
                'name' => 'Institutional Support',
                'sector_id' => 4,
            ],
            [
                'name' => 'Air / Airoport transport',
                'sector_id' => 7,
            ],
            [
                'name' => 'Land transport / Highways',
                'sector_id' => 7,
            ],
            [
                'name' => 'Rail transport',
                'sector_id' => 7,
            ],
            [
                'name' => 'Water and river transport / Ports',
                'sector_id' => 7,
            ],
            [
                'name' => 'Pipeline transport',
                'sector_id' => 7,
            ],
            [
                'name' => 'Secondary roads',
                'sector_id' => 7,
            ],
            [
                'name' => 'urban transport',
                'sector_id' => 7,
            ],
            [
                'name' => 'More than a transport sub-sector',
                'sector_id' => 7,
            ],
            [
                'name' => 'Other transport',
                'sector_id' => 7,
            ],
            [
                'name' => 'Transport Public Administration',
                'sector_id' => 7,
            ],
        ]);
    }
}
