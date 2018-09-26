<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Round as RoundResource;
use App\Models\Tournament;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        //Validate post request
        $v = Validator::make($r->all(), [
            'tournament_id' => 'required|exists:tournaments,id',
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

        $round = Tournament::find($r->tournament_id)->createRound();
        if (!$round) {
            $response = [
                'success' => false,
                'errors' => 'Last round has not been paired. Either delete, or pair round.',
                'data' => [],
            ];
            return response()
                ->json($response)
                ->setStatusCode(400);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    /**
     * Non-resource functions
     */

     /**
      * Create matches for specified round.
      *
      * @param  int  $id
      * @return \App\Http\Responses\Round
      */
}
