<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;

use App\Http\Resources\Round as RoundResource;
use App\Http\Resources\Collections\Matches;
use App\Models\Tournament;
use App\Models\Round;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tournamentId)
    {
        //Validate $tournamentId
        $v = Validator::make(['tournamentId' => $tournamentId],[
            'tournamentId' => 'required|exists:tournaments,id',
        ]);
        if ($v->fails())
            return $this->errors($v);

        return (new Rounds (Tournament::findOrFail($tournamentId)->rounds))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Create a new resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create($tournamentId)
    {
        //Validate $tournamentId variable
        $v = Validator::make(['tournamentId' => $tournamentId], [
            'tournamentId' => 'required|exists:tournaments,id',
        ]);
        if ($v->fails())
            return $this->errors($v);

        $round = Tournament::find($tournamentId)->createRound();
        if (!$round){
            $v->errors()->add('id', 'Blank round already created');
            return $this->errors($v, 500);
        }
        
        return (new RoundResource($round))
            ->response()
            ->setStatusCode(201);
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
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:rounds']);
        if ($v->fails())
            return $this->errors($v);

        return (new RoundResource (Round::findOrFail($id)))
            ->response()
            ->setStatusCode(200);;
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
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:rounds']);
        if ($v->fails())
            return $this->errors($v);

        $round = Round::destroy($id);

        return response()->setStatusCode(200);
    }

    /**
     * Non-resource functions
     */

     /**
      * Create matches for specified round.
      *
      * @param  int  $id
      * @return \App\Http\Responses\Round
      */
      public function pair ($id) {
        //Validate $id
        $v = Validator::make(['id' => $id], ['id' => 'required|integer|exists:rounds']);
        if ($v->fails())
            return $this->errors($v);

        $round = Round::find($id);
        if ($round->createMatches())
            return new Matches ($round->matches);
        else {
            $v->errors()->add('id', 'Error in pairing round, contact developer');
            return response()->json($this->errors($v))->setStatusCode(400);
        }

      }
}
