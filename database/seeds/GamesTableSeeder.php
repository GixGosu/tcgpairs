<?php

use App\Models\Game;
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

        foreach ($insertion as $record) {
            $game = new Game ();
            $game->title = $record['title'];
            $game->abbrv = $record['abbrv'];
            $game->save ();
        }
    }
}
