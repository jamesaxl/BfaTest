<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\SectorInfo;
use App\Model\SectorDataGrid;v

class SectorInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectors = SectorInfo::with('sector', 'country')->all();
        return response()->json($sectors);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(SectorDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sector = SectorInfo::create($request->all());

        return response()->json([
            'error' => 0,
            'message' => 'sector-info has been registered'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\SectorInfo  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sector = SectorInfo::with('sector', 'country')->find($id);
        if (!$sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sector-info with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $sector ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Sector  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectorUpdate $request, $id)
    {
        $sector = SectorInfo::find($id);

        if (!$sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sector-info with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $sector->fill($request->all())->save();

        if ($updated) {

            return response()->json([
                'error' => 0,
                'message' => 'sector-info has been updated'
            ]);
        } else {
            return response()->json([
                'error' => 1,
                'message' => 'sector-info could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sector = SectorInfo::find($id);

        if (!$sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sector-info with id ' . $id . ' not found'
            ], 400);
        }

        $sector->delete();
        return response()->json([
            'error' => 0,
            'message' => 'sector-info has been deleted'
        ]);
    }
}
