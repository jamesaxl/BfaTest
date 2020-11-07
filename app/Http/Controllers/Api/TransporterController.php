<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Transporter;
use App\Model\Organization;
use App\Model\Wallet;
use App\Http\Requests\Transporter\Store;
use App\Http\Requests\Transporter\Update;
use App\Http\DataGrids\TransporterDataGrid;
use Illuminate\Support\Str;

class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transporters = Transporter::with( 'organization',
                                            'organization.country',
                                            'organization.nationality',
                                            'organization.city',
                                            'organization.sectors',
                                            'organization.subSectors',
                                            'organization.organizationType',
                                            'organization.organizationSubType',
                                            'organization.wallet')->paginate(30);

        return response()->json($transporters);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(TransporterDataGrid $datagrid)
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

        $transporter = Transporter::create(
            $request->all()
        );

        $transporter->id = $organization->id;
        $transporter->organization_id = $organization->id;

        if ($request->hasFile('photo_path')) {
            $organization->uploadLogo($request->file('photo_path'));
        }

        $specialities = $request->specialities;
        $organization->storeSpeciality($specialities);

        // wallet
        $wallet = Wallet::create(
            [
                'ref' => (string) Str::uuid(),
                'organization_id' => $organization->id,
            ]
        );

        return response()->json([ 'error' => 0,
                                  'message' => 'Transporter has been registered',
                                  'data' => $organization, ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Transporter  $transporter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transporter = Transporter::with('organization',
                                            'organization.country',
                                            'organization.nationality',
                                            'organization.city',
                                            'organization.sectors',
                                            'organization.subSectors',
                                            'organization.organizationType',
                                            'organization.organizationSubType',
                                            'organization.wallet')->find($id);

        if (!$transporter) {
            return response()->json([
                'error' => 1,
                'message' => 'Transporter with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $transporter ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Transporter  $transporter
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->transporter ) {
            return response()->json([
                'error' => 1,
                'message' => 'Transporter with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_transporter = $organization->transporter->fill($request->all())->save();

        if ($updated && $updated_transporter) {
            if ($request->hasFile('photo_path')) {
                if ($organization->photo_path)
                    unlink(public_path().'/'.$organization->photo_path);

                $organization->uploadLogo($request->file('photo_path'));
            }

            $specialities = $request->specialities;
            if ($specialities) {
                $organization->updateSpecility($specialities);
            }

            return response()->json([
                'error' => 0,
                'message' => 'Transporter has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'Transporter could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Transporter  $transporter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->transporter ) {
            return response()->json([
                'error' => 1,
                'message' => 'Transporter with id ' . $id . ' not found'
            ], 400);
        }

        if ($organization->photo_path)
            unlink(public_path().'/'.$organization->photo_path);

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Transporter has been deleted'
        ]);
    }
}
