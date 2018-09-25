<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $insertion = [
            [
                'title' => 'Magic: The Gathering',
                'abbrv' => 'MTG',
            ],
            [
                'title' => 'Yu-Gi-Oh',
                'abbrv' => 'YGO',
            ],
            [
                'title' => 'Final Fantasy TCG',
                'abbrv' => 'FFTCG',
            ],
        ];

        \DB::table('games')->insert($insertion);
    }
}
