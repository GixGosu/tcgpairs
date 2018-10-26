<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Team;
use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\Collections\Teams;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Validate get request
        $validate = Validator::make($request->all(), [
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ]);
        if ($validate->fails())
            return $this->errors($validate);

        //Get the 10 most recent Teams
        return (new Teams (Team::orderBy('event_time', 'desc')
            ->paginate(isset($request->perPage)?$request->perPage:10)))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Create a new resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Validate post request
        $validate = Validator::make($request->all(), [
            'teamName' => 'required|string',
            'tournamentId' => 'required|integer'
        ]);

        if ($validate->fails())
            return $this->errors($validate);

        //Create a new Team and return it's information
        $Team = new Team ();
        $Team->team_name = $request->teamName;
        $Team->tournament_id = $request->tournamentId;
        $Team->save();

        return (new TeamResource($Team))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validate put request
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:Teams,id',
            'title' => 'sometimes|string',
            'eventTime' => 'sometimes|date',
            'gameId' => 'exists:games,id',
            'formatId' => 'exists:formats,id',
        ]);

        if ($validate->fails())
            return $this->errors($validate);

        //Update an existing Team and return it's information
        $Team = Team::findOrFail($request->id);
        if (isset($request->title))
            $Team->title = $request->title;

        if (isset($request->eventTime))
            $Team->event_time = $request->eventTime;

        if (isset($request->gameId))
            $Team->game_id = $request->gameId;

        if (isset($request->formatId))
            $Team->format_id = $request->formatId;

        $Team->save();

        return (new TeamResource($Team))
            ->response()
            ->setStatusCode(200);
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:Teams']);
        if ($validate->fails())
            return $this->errors($validate);

        $Team = Team::findOrFail($id);

        return new TeamResource($Team);
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:Teams']);
        if ($validate->fails())
            return $this->errors($validate);

        $Team = Team::findOrFail($id)->delete();

        return response()->setStatusCode(200);
    }

}
