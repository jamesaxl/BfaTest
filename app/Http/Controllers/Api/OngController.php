<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Ong;
use App\Model\Organization;
use App\Model\Wallet;
use App\Http\Requests\Ong\Store;
use App\Http\Requests\Ong\Update;
use App\Http\DataGrids\OngDataGrid;
use App\User;
use Illuminate\Support\Str;

class OngController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ongs = Ong::with('organization',
                            'organization.country',
                            'organization.city',
                            'organization.sectors',
                            'organization.subSectors',
                            'organization.organizationType',
                            'organization.organizationSubType',
                            'organization.wallet')->paginate(30);
        return response()->json($ongs);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(OngDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $organization = Ong::create(
            $request->all()
        );

        $ong = Ong::create(
            $request->all()
        );

        $ong->id = $organization->id;
        $ong->organization_id = $organization->id;
        $ong->save();

        if (auth()->user()->account_type_id == $organization->organization_type_id) {
            auth()->user()->organization_id = $organization->id;
            auth()->user()->save();
        }

        // wallet
        $wallet = Wallet::create(
            [
                'ref' => (string) Str::uuid(),
                'organization_id' => $organization->id,
            ]
        );

        return response()->json([ 'error' => 0,
                                  'message' => 'Ong has been registered',
                                  'data' => $ong, ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ong  $ong
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ong = Ong::with('organization',
            'organization.country',
            'organization.city',
            'organization.sectors',
            'organization.subSectors',
            'organization.organizationType',
            'organization.organizationSubType',
            'organization.wallet')->find($id);

        if (!$ong) {
            return response()->json([
                'error' => 1,
                'message' => 'Ong with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $ong ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ong  $ong
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || $organization->ong) {
            return response()->json([
                'error' => 1,
                'message' => 'Ong with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_ong = $organization->ong->fill($request->all())->save();

        if ( $updated && $updated_ong ) {

            return response()->json([
                'error' => 0,
                'message' => 'Ong has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'Ong could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ong  $ong
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || $organization->ong) {
            return response()->json([
                'error' => 1,
                'message' => 'Ong with id ' . $id . ' not found'
            ], 400);
        }

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Ong has been deleted'
        ]);
    }
}
