<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Continent;
use App\Http\Controllers\Controller;

class ContinentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $continents = Continent::all();
        return response()->json($continents);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $continent = Continent::with('countries')->where('id', $id)->first();
        if (!$continent) {
            return response()->json([
                'error' => 1,
                'message' => 'continent with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $continent ]);
    }
}
