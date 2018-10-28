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
    public function index(Request $request, $tournamentId)
    {
        //Validate GET request
        $validate = Validator::make(array_merge($request->all(),['tournamentId'=>$tournamentId]), [
            'tournamentId' => 'required|integer|exists:tournaments,id',
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ]);
        if ($validate->fails())
            return $this->errors($validate);

        $perPage = isset($request->perPage)?$request->perPage:10;
        return new Rosters (Roster::where('tournament_id', $request->tournamentId)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, $tournamentId)
    {
        //Validate POST request, set variables
        $validate = Validator::make(['tournamentId' => $tournamentId], [
            'tournamentId' => 'required|integer|exists:tournaments,id',
        ]);
        if ($validate->fails())
            return $this->errors($validate);

        $tournament = Tournament::find($tournamentId);
        $validate2 = Validator::make($request->all(), [
            'teamName' => 'sometimes|string',
            'players' => 'required|array|size:'.$tournament->format->team_size,
            'players.*.id' => [
                'required',
                'integer',
                'exists:players,id',
                Rule::unique('rosters', 'player_id')->where(function ($query) use ($tournament) {
                    return $query->where('tournament_id', $tournament->id);
                })
            ],
            'players.*.slot' => 'sometimes|integer',
        ]);

        if ($validate2->fails())
            return $this->errors($validate2);
        //Done validating

        //Create a team
        $team = new Team;
        $team->active = true;
        $team->tournament_id = $tournament->id;
        $team->save();

        foreach ($request->players as $p) {
            $player = Player::find($p['id']);
            $roster = new Roster;
            $roster->tournament_id = $tournament->id;
            $roster->player_id = $p['id'];
            $roster->team_id = $team->id;
            $roster->save();
            $default = isset($default)?$default . ' - ' : '';
            $default .= $player->l_name;
            $default .= count($request->players)==1?', ' . $player->f_name : '';
        }

        $team->team_name = isset($request->teamName)?$request->teamName:$default;
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:roster']);
        if ($validate->fails())
            return $this->errors($validate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:roster']);
        if ($validate->fails())
            return $this->errors($validate);

        Roster::destroy($id);

        return response()->setStatusCode(200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTeam($id)
    {
        //Validate $id
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:teams']);
        if ($validate->fails())
            return $this->errors($validate);

        $team = Team::find($id);
        $team->players->delete();
        $team->delete();

        return response()->setStatusCode(200);

    }
}
