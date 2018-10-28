<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;

use App\Models\Format;
use App\Http\Resources\Format as FormatResource;
use App\Http\Resources\Collections\Formats;

class FormatController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Validate get request
        $validate = Validator::make($request->all(), 
            array_merge($this->validateBoth(), [
                'gameId' => 'required|exists:games,id',
            ])
        );
        if ($validate->fails())
            return $this->errors($validate);
            
        $perPage = isset($request->perPage)?$request->perPage: $this->perPage;
        $sortBy = isset($request->sortBy) ? $request->sortBy : $this->sortBy;
        $sortOrder = isset($request->sortOrder) ? $request->sortOrder : $this->sortOrder;
        
        return new Formats (Format::where('game_id', $request->gameId)->setOrder($sortBy, $sortOrder)->paginate($perPage));
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:formats']);
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
        $validate = Validator::make(['id' => $id], ['id' => 'required|integer|exists:formats']);
        if ($validate->fails())
            return $this->errors($validate);
    }
}
