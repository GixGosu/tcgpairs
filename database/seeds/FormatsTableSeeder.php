<?php

use Illuminate\Database\Seeder;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertion = [
            [
                'game_id' => 1,
                'title' => 'Draft',
                'type' => 'Limited',
                'is_draft' => 1,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 1,
                'title' => 'Standard',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 1,
                'title' => 'Modern',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 1,
                'title' => 'Legacy',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 1,
                'title' => 'Pauper',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 1,
                'title' => 'Two-Headed Giant - Sealed',
                'type' => 'Limited',
                'is_draft' => 0,
                'team_size' => 2,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 1,
                'title' => 'Commander - EDH',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 4,
            ],
            [
                'game_id' => 2,
                'title' => 'Advanced',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 3,
                'title' => 'Standard',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 3,
                'title' => 'Title Series',
                'type' => 'Constructed',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 3,
                'title' => 'Draft',
                'type' => 'Limited',
                'is_draft' => 1,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
            [
                'game_id' => 3,
                'title' => 'Sealed',
                'type' => 'Limited',
                'is_draft' => 0,
                'team_size' => 1,
                'number_of_teams' => 2,
            ],
        ];

        \DB::table('formats')->insert($insertion);
    }
}
