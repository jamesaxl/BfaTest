<?php

namespace App\Http\Controllers\Api;

use App\Model\SubSector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubSectorStore;
use App\Http\Requests\SubSectorUpdate;
use App\Http\DataGrids\SubSectorDataGrid;

class SubSectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_sectors = SubSector::with('sector')->get();
        return response()->json($sub_sectors);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(SubSectorDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexInSector($sector_id)
    {
        $sub_sectors = SubSector::where('sector_id',$sector_id )->get();
        return response()->json($sub_sectors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubSectorStore $request)
    {
        $sub_sector = SubSector::create([
            'name' => $request->name,
            'sector_id' => $request->sector_id,
        ]);

        return response()->json([
            'error' => 0,
            'message' => 'sub-sector has been registered'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\SubSector  $subSector
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sub_sector = SubSector::with('sector')->where('id', $id)->first();
        if (!$sub_sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sub_sector with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json(['error' => 0, 'data' => $sub_sector ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\SubSector  $subSector
     * @return \Illuminate\Http\Response
     */
    public function update(SubSectorUpdate $request, $id)
    {
        $sub_sector = SubSector::find($id);

        if (!$sub_sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sub_sector with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $sub_sector->fill($request->all())->save();

        if ($updated) {

            return response()->json([
                'error' => 0,
                'message' => 'sub_sector has been updated'
            ]);
        } else {
            return response()->json([
                'error' => 1,
                'message' => 'sub_sector could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\SubSector  $subSector
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sub_sector = SubSector::find($id);

        if (!$sub_sector) {
            return response()->json([
                'error' => 1,
                'message' => 'sub_sector with id ' . $id . ' not found'
            ], 400);
        }

        $sub_sector->delete();
        return response()->json([
            'error' => 0,
            'message' => 'sub_sector has been deleted'
        ]);
    }
}
