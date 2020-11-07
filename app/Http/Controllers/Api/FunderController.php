<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Funder;
use App\Model\Wallet;
use App\User;
use App\Model\Sector;
use App\Model\ManyToMany\Funder\FunderSector;
use App\Http\Requests\Funder\Store;
use App\Http\Requests\Funder\Update;
use App\Model\Organization;
use App\Http\DataGrids\FunderDataGrid;
use Illuminate\Support\Str;

class FunderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funders = Funder::with('organization',
                                'organization.country',
                                'organization.city',
                                'organization.sectors',
                                'organization.subSectors',
                                'organization.organizationType',
                                'organization.organizationSubType',
                                'organization.wallet')->paginate(30);

        return response()->json($funders);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(FunderDataGrid $datagrid)
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
        $organization = Organization::create(
            $request->all()
        );

        $funder = Funder::create(
            $request->all()
        );

        $funder->id = $organization->id;
        $funder->organizationid = $organization->id;
        $funder->save();

        $sectors = $request->sectors;
        $organization->storeSector($sectors);

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

        return response()->json([ 'error' => 0, 'message' => 'Funder has been registered' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Funder  $funder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $funder = Funder::with(
                            'organization',
                            'organization.country',
                            'organization.city',
                            'organization.sectors',
                            'organization.subSectors',
                            'organization.organizationType',
                            'organization.organizationSubType',
                            'organization.wallet')->find($id);

        if (!$funder) {
            return response()->json([
                'error' => 1,
                'message' => 'Funder with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json([ 'error' => 0, 'data' => $funder ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Funder  $funder
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->funder) {
            return response()->json([
                'error' => 1,
                'message' => 'Funder with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updatedFunder = $organization->funder->fill($request->all())->save();

        if ($updated && $updatedFunder) {
            $sectors = $request->sectors;
            if ($sectors) {
                $organization->sectors()->allRelatedIds();
                $organization->sectors()->sync($sectors);
                $organization->sectors()->allRelatedIds();
            }

            return response()->json([
                'error' => 0,
                'message' => 'Funder has been updated'
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'Funder could not be updated'
        ], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Funder  $funder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->funder) {
            return response()->json([
                'error' => 1,
                'message' => 'Funder with id ' . $id . ' not found'
            ], 400);
        }

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Funder has been deleted'
        ]);
    }
}
