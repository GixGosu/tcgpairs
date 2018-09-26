<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Game;
use App\Http\Resources\Game as GameResource;
use App\Http\Resources\Games;

class GameController extends Controller
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
            'limit' => 'integer',
            'offset' => 'integer',
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
        $limit = isset($r->limit)?$r->limit:10;

        return new Games (Game::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
