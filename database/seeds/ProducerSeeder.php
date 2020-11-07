<?php

use Illuminate\Database\Seeder;

class ProducerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('producers')->insert([
            [
                'name' => 'scrapping',
            ],
            [
                'name' => 'platform director',
            ],
            [
                'name' => 'head of platform section',
            ],
            [
                'name' => 'platform staff',
            ],
            [
                'name' => 'platform focal point',
            ],
            [
                'name' => 'lobbyist',
            ],
            [
                'name' => 'platform expert',
            ],
            [
                'name' => 'logistician',
            ],
            [
                'name' => 'general manager',
            ],
            [
                'name' => 'director',
            ],
            [
                'name' => 'manager',
            ],
            [
                'name' => 'task manager',
            ],
            [
                'name' => 'ministry',
            ],
            [
                'name' => 'executing agency',
            ],
            [
                'name' => 'assistant',
            ],
            [
                'name' => 'consultant',
            ],
            [
                'name' => 'trader',
            ],
        ]);
    }
}
