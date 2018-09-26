<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Format;
use App\Http\Resources\Format as FormatResource;
use App\Http\Resources\Formats;

class FormatController extends Controller
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
            'game_id' => 'required|exists:games,id',
            'limit' => 'integer',
            'page' => 'integer',
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
        
        if (isset($r->limit)) {
            return new Formats (Format::where('game_id', $r->game_id)->paginate($r->limit));
        } else {
            return new Formats (Format::where('game_id', $r->game_id)->get());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
