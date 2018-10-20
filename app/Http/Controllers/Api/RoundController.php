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
        $validate = Validator::make(['tournamentId' => $tournamentId],[
            'tournamentId' => 'required|exists:tournaments,id',
        ]);
        if ($validate->fails())
            return $this->errors($validate);

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
        $validate = Validator::make(['tournamentId' => $tournamentId], [
            'tournamentId' => 'required|exists:tournaments,id',
        ]);
        if ($validate->fails())
            return $this->errors($validate);

        $round = Tournament::find($tournamentId)->createRound();
        if (!$round){
            $validate->errors()->add('id', 'Blank round already created');
            return $this->errors($validate, 500);
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:rounds']);
        if ($validate->fails())
            return $this->errors($validate);

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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:rounds']);
        if ($validate->fails())
            return $this->errors($validate);

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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:rounds']);
        if ($validate->fails())
            return $this->errors($validate);

        $round = Round::findOrFail($id);
        if ($round->createMatches())
            return new Matches ($round->matches);
        else {
            $validate->errors()->add('id', 'Error in pairing round, contact developer');
            return $this->errors($validate, 500);
        }

      }

      /**
       * Show matches for specified round.
       * 
       * @param int $id
       * @return \App\Http\Responses\Collections\Matches
       */
        public function matches ($id) {
            $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:rounds']);
            if ($validate->fails())
                return $this->errors($validate);

            $round = Round::findOrFail($id);
            if (!empty($round->matches))
                return (new Matches($round->matches))->response()->setStatusCode(200);
            else
                return $this->customErrors('Round has not been paired.');
        }
    }
