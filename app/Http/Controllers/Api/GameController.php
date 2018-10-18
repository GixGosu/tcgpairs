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
    public function index(Request $request)
    {
        //Validate get request
        $validate = Validator::make($request->all(), [
            'perPage' => 'required_with:page|integer',
            'page' => 'sometimes|integer',
        ]);
        if ($validate->fails())
            return $this->errors($validate);
        
        //Return a list of games with pagination (default 10)
        return new Games (Game::paginate(isset($request->perPage)?$request->perPage:10));
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:games']);
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:games']);
        if ($validate->fails())
            return $this->errors($validate);
    }
}
