<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\Roster;
use App\Models\Player;
use App\Models\Tournament;
use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\Roster as RosterResource;
use App\Http\Resources\Collections\Rosters;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        //Validate GET request
        $v = Validator::make($r->all(), [
            'tournamentId' => 'required|integer|exists:tournaments,id',
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ]);
        if ($v->fails())
            return $this->errors($v);

        $perPage = isset($r->perPage)?$r->perPage:10;
        return new Rosters (Roster::where('tournament_id', $r->tournamentId)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        //Validate POST request, set variables
        $v = Validator::make($r->all(), [
            'tournamentId' => 'required|integer|exists:tournaments,id',
            'teamName' => 'sometimes|string',
        ]);
        if ($v->fails())
            return $this->errors($v);

        $t = Tournament::find($r->tournamentId);
        $v2 = Validator::make($r->all(), [
            'players' => 'required:playerId|array|size:'.$t->format->team_size,
            'players.*.id' => [
                'required',
                'integer',
                'exists:players,id',
                Rule::unique('rosters', 'player_id')->where(function ($query) use ($t) {
                    return $query->where('tournament_id', $t->id);
                })
            ],
            'players.*.slot' => 'sometimes|integer',
        ]);

        if ($v2->fails())
            return $this->errors($v2);
        //Done validating

        //Create a team
        $team = new Team;
        $team->active = true;
        $team->tournament_id = $t->id;
        $team->save();

        foreach ($r->players as $p) {
            $player = Player::find($p['id']);
            $roster = new Roster;
            $roster->tournament_id = $t->id;
            $roster->player_id = $p['id'];
            $roster->team_id = $team->id;
            $roster->save();
            $default = isset($default)?$default . ' - ' : '';
            $default .= $player->l_name;
            $default .= count($r->players)==1?', ' . $player->f_name : '';
        }

        $team->team_name = isset($r->teamName)?$r->teamName:$default;
        $team->save();

        return new TeamResource ($team);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Validate $id
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:roster']);
        if ($v->fails())
            return $this->errors($v);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Validate $id
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:roster']);
        if ($v->fails())
            return $this->errors($v);
    }
}
