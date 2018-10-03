<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;

use App\Models\Tournament;
use App\Http\Resources\Tournament as TournamentResource;
use App\Http\Resources\Collections\Tournaments;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        //Validate get request
        $v = Validator::make($r->all(), [
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ]);
        if ($v->fails())
            return $this->errors($v);

        //Get the 10 most recent tournaments
        return (new Tournaments (Tournament::orderBy('event_time', 'desc')
            ->paginate(isset($r->perPage)?$r->perPage:10)))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Create a new resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $r)
    {
        //Validate post request
        $v = Validator::make($r->all(), [
            'title' => 'required|string',
            'eventTime' => 'date',
            'gameId' => 'required|exists:games,id',
            'formatId' => 'required|exists:formats,id',
        ]);

        if ($v->fails()) 
            return $this->errors($v);

        //Create a new tournament and return it's information
        $tournament = new Tournament ();
        $tournament->title = $r->title;
        $tournament->event_time = isset($r->eventTime)?$r->eventTime:now();
        $tournament->game_id = $r->gameId;
        $tournament->format_id = $r->formatId;
        $tournament->save();

        return (new TournamentResource($tournament))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        //Validate put request
        $v = Validator::make($r->all(), [
            'id' => 'required|exists:tournaments,id',
            'title' => 'sometimes|string',
            'eventTime' => 'sometimes|date',
            'gameId' => 'exists:games,id',
            'formatId' => 'exists:formats,id',
        ]);

        if ($v->fails()) 
            return $this->errors($v);

        //Update an existing tournament and return it's information
        $tournament = Tournament::findOrFail($r->id);
        if (isset($r->title))
            $tournament->title = $r->title;

        if (isset($r->eventTime))
            $tournament->event_time = $r->eventTime;

        if (isset($r->gameId))
            $tournament->game_id = $r->gameId;

        if (isset($r->formatId))
            $tournament->format_id = $r->formatId;
            
        $tournament->save();

        return (new TournamentResource($tournament))
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
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:tournaments']);
        if ($v->fails())
            return $this->errors($v);
            
        $tournament = Tournament::findOrFail($id);

        return new TournamentResource($tournament);
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
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:tournaments']);
        if ($v->fails())
            return $this->errors($v);

        $tournament = Tournament::findOrFail($id)->delete();

        return response()->setStatusCode(200);
    }

}
