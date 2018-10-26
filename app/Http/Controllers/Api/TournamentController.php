<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Carbon\Carbon;
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
    public function index(Request $request)
    {
        //Validate get request
        $validate = Validator::make($request->all(), [
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ]);
        if ($validate->fails())
            return $this->errors($validate);

        //Get the 10 most recent tournaments
        return (new Tournaments (Tournament::orderBy('event_time', 'desc')
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
            'title' => 'required|string',
            'eventTime' => 'date',
            'gameId' => 'required|exists:games,id',
            'formatId' => 'required|exists:formats,id',
        ]);

        if ($validate->fails())
            return $this->errors($validate);

        //Create a new tournament and return it's information
        $tournament = new Tournament ();
        $tournament->title = $request->title;
        $tournament->event_time = isset($request->eventTime) ? Carbon::parse($request->eventTime) : now();
        $tournament->game_id = $request->gameId;
        $tournament->format_id = $request->formatId;
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
    public function update(Request $request)
    {
        //Validate put request
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:tournaments,id',
            'title' => 'sometimes|string',
            'eventTime' => 'sometimes|date',
            'gameId' => 'exists:games,id',
            'formatId' => 'exists:formats,id',
        ]);

        if ($validate->fails())
            return $this->errors($validate);

        //Update an existing tournament and return it's information
        $tournament = Tournament::findOrFail($request->id);
        if (isset($request->title))
            $tournament->title = $request->title;

        if (isset($request->eventTime))
            $tournament->event_time = $request->eventTime;

        if (isset($request->gameId))
            $tournament->game_id = $request->gameId;

        if (isset($request->formatId))
            $tournament->format_id = $request->formatId;

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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:tournaments']);
        if ($validate->fails())
            return $this->errors($validate);

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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:tournaments']);
        if ($validate->fails())
            return $this->errors($validate);

        $tournament = Tournament::findOrFail($id)->delete();

        return response()->setStatusCode(200);
    }

}
