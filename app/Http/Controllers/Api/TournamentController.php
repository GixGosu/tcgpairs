<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tournament;
use App\Http\Resources\Tournament as TournamentResource;
use App\Http\Resources\Tournaments;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get the 5 most recent tournaments
        return new Tournaments (Tournament::orderBy('event_time', 'desc')->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        //Validate post request
        $v = Validator::make($r->all(), [
            'title' => 'required|string',
            'event_time' => 'date',
            'game_id' => 'required|exists:games,id',
            'format_id' => 'required|exists:formats,id',
        ]);

        if ($v->fails()) {
            $errs = $v->errors();
            $response = [
                'success' => false,
                'errors' => $errs->all(),
                'data' => [],
            ];
            return response()
                ->json($response)
                ->setStatusCode(400);
        }

        //Create a new tournament and return it's information
        $tournament = new Tournament ();
        $tournament->title = $r->title;
        $tournament->event_time = isset($r->event_time)?$r->event_time:now();
        $tournament->game_id = $r->game_id;
        $tournament->format_id = $r->format_id;
        $tournament->save();

        return (new TournamentResource($tournament))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        //Validate put request
        $v = Validator::make($r->all(), [
            'id' => 'required|exists:tournaments,id',
            'title' => 'string',
            'event_time' => 'date',
            'fk_game_id' => 'exists:games,id',
            'fk_format_id' => 'exists:formats,id',
        ]);

        if ($v->fails()) {
            $errs = $v->errors();
            $response = [
                'success' => false,
                'errors' => $errs->all(),
                'data' => [],
            ];
            return response()
                ->json($response)
                ->setStatusCode(400);
        }

        //Create a new tournament and return it's information
        $tournament = Tournament::findOrFail($r->id);
        if (isset($r->title))
            $tournament->title = $r->title;

        if (isset($r->event_time))
            $tournament->event_time = $r->event_time;

        if (isset($r->fk_game_id))
            $tournament->fk_game_id = $r->fk_game_id;

        if (isset($r->fk_format_id))
            $tournament->fk_format_id = $r->fk_format_id;
            
        $tournament->save();

        return (new TournamentResource($tournament))
            ->response()
            ->setStatusCode(202);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
