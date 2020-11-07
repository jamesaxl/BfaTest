<?php

use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document_types')->insert([
            [
                'name' => 'strategies and policies',
            ],
            [
                'name' => 'donor procedure',
            ],
            [
                'name' => 'agreements',
            ],
            [
                'name' => 'country Procedures',
            ],
            [
                'name' => 'project documents',
            ],
            [
                'name' => 'economic and sector studies',
            ],
            [
                'name' => 'acquisition documents',
            ],
            [
                'name' => 'other document',
            ]
        ]);
    }
}
