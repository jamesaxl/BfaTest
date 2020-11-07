<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Country;
use App\Http\Controllers\Controller;
use App\Http\DataGrids\CountryDataGrid;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(CountryDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::with('cities')->where('id', $id)->first();
        if (!$country) {
            return response()->json([
                'error' => 1,
                'message' => 'country with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $country ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexInContinent($continent_id)
    {
        $countries = Country::where('continent_id',$continent_id )->get();
        return response()->json($countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ong  $ong
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'error' => 1,
                'message' => 'Country with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $country->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'error' => 0,
                'message' => 'Country has been updated'
            ]);
        else
            return response()->json([
                'error' => 1,
                'message' => 'Country could not be updated'
            ], 500);

    }
}
