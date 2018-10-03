<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;

use App\Models\Game;
use App\Http\Resources\Game as GameResource;
use App\Http\Resources\Collections\Games;

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
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ]);
        if ($v->fails())
            return $this->errors($v);
        
        //Return a list of games with pagination (default 10)
        return new Games (Game::paginate(isset($r->perPage)?$r->perPage:10));
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
        //Validate $id
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:games']);
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
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:games']);
        if ($v->fails())
            return $this->errors($v);
    }
}
