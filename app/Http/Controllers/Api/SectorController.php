<?php

namespace App\Http\Controllers\Api;

use App\Model\Sector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\DataGrids\SectorDataGrid;
use App\Http\Requests\SectorStore;
use App\Http\Requests\SectorUpdate;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectors = Sector::with('subSectors')->get();
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
    public function store(SectorStore $request)
    {
        $sector = Sector::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'error' => 0,
            'message' => 'sector has been registered'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sector = Sector::with('subSectors')->where('id', $id)->first();
        if (!$sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sector with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $sector ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(SectorUpdate $request, $id)
    {
        $sector = Sector::find($id);

        if (!$sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sector with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $sector->fill($request->all())->save();

        if ($updated) {

            return response()->json([
                'error' => 0,
                'message' => 'sector has been updated'
            ]);
        } else {
            return response()->json([
                'error' => 1,
                'message' => 'sector could not be updated'
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
        $sector = Sector::find($id);

        if (!$sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sector with id ' . $id . ' not found'
            ], 400);
        }

        $sector->delete();
        return response()->json([
            'error' => 0,
            'message' => 'sector has been deleted'
        ]);
    }
}
