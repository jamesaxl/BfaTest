<?php

namespace App\Http\Controllers\Api;

use App\Model\Fund;
use Illuminate\Http\Request;
use App\Http\DataGrids\FundDataGrid;
use App\Http\Controllers\Controller;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funds = Fund::paginate(30);
        return response()->json($funds);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(FundDataGrid $datagrid)
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
        $fund = Fund::create(
            $request->all()
        );

        return response()->json([
            'error' => 0,
            'message' => 'fund has been registered'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Sector  $fund
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fund = Fund::find($id);
        if (!$fund) {
            return response()->json([
                'error' => 1,
                'message' => 'fund with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $fund ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Sector  $fund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fund = Fund::find($id);

        if (!$fund) {
            return response()->json([
                'error' => 1,
                'message' => 'fund with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $fund->fill($request->all())->save();

        if ($updated) {

            return response()->json([
                'error' => 0,
                'message' => 'sector has been updated'
            ]);
        } else {
            return response()->json([
                'error' => 1,
                'message' => 'fund could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Sector  $fund
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fund = Fund::find($id);

        if (!$fund) {
            return response()->json([
                'error' => 1,
                'message' => 'fund with id ' . $id . ' not found'
            ], 400);
        }

        $fund->delete();
        return response()->json([
            'error' => 0,
            'message' => 'fund has been deleted'
        ]);
    }
}
