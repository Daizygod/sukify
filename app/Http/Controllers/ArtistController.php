<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class ArtistController extends Controller
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

    /**
     * Get list of rows in db
     *
     */
    public function getAjax(Request $request)
    {
        $searchString = $request->input('search');
        $response = array();
        $artists = Artist::where('name', 'like', '%' . $searchString . '%')->get();
        foreach($artists as $artist){
            $response[] = array(
                "id"=>$artist->id,
                "text"=>$artist->name
            );
        }
        return response()->json($response);
        //if (is_null($input_text)) {
            //var_dump(Artist::all()->limit(10)->get()->toArray());
        //return var_dump(34343);
        //return ;//Artist::all()->first()->toArray();
        //return "{ \"results\": " . json_encode(['id' => 1, 'value' => 'Kizaruch']) . "}";
        // }
    }
}
