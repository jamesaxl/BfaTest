<?php

namespace App\Http\Controllers\Api;

use App\Model\Government;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Wallet;
use App\Model\ManyToMany\Organization;
use App\Http\Requests\Government\Store;
use App\Http\Requests\Government\Update;
use App\Http\DataGrids\GovernmentDataGrid;
use Illuminate\Support\Str;

class GovernmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $governments = Government::with('organization',
                                    'organization.country',
                                    'organization.city',
                                    'organization.sectors',
                                    'organization.subSectors',
                                    'organization.organizationType',
                                    'organization.organizationSubType',
                                    'organization.wallet')->paginate(30);

        return response()->json($governments);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(GovernmentDataGrid $datagrid)
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

        $government = Government::create(
            $request->all()
        );

        $government->id = $organization->id;
        $government->organization_id = $organization->id;
        $government->save();

        if ($request->hasFile('photo_path')) {
            $organization->uploadLogo($request->file('photo_path'));
        }

        $qualifications = $request->qualifications;
        if ($qualifications) {
            $organization->updateQualification($qualifications);
        }

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
                                  'message' => 'Government has been registered',
                                  'data' => $organization, ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Government  $government
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $government = Government::with( 'organization',
                                        'organization.country',
                                        'organization.city',
                                        'organization.sectors',
                                        'organization.subSectors',
                                        'organization.organizationType',
                                        'organization.organizationSubType',
                                        'organization.wallet')->find($id);
        if (!$government) {
            return response()->json([
                'error' => 1,
                'message' => 'Government with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $government ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Government  $government
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || $organization->government) {
            return response()->json([
                'error' => 1,
                'message' => 'Government with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_government = $organization->government->fill($request->all())->save();

        if ($updated && $updated_government) {
            if ($request->hasFile('photo_path')) {
                if ($organization->photo_path)
                    unlink(public_path().'/'.$organization->photo_path);

                $organization->uploadLogo($request->file('photo_path'));
            }

            $qualifications = $request->qualifications;
            if ($qualifications) {
                $organization->updateQualification($qualifications);
            }

            return response()->json([
                'error' => 0,
                'message' => 'Government has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'Government could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Government  $government
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || $organization->government) {
            return response()->json([
                'error' => 1,
                'message' => 'Government with id ' . $id . ' not found'
            ], 400);
        }

        if ($organization->photo_path)
            unlink(public_path().'/'.$organization->photo_path);
        $organization->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Government has been deleted'
        ]);
    }
}
