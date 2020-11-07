<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Investor;
use App\Model\Organization;
use App\Model\Wallet;
use App\Http\Requests\Investor\Store;
use App\Http\Requests\Investor\Update;
use App\Http\DataGrids\InvestorDataGrid;
use Illuminate\Support\Str;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investor = Investor::with('organization',
                                'organization.country',
                                'organization.city',
                                'organization.sectors',
                                'organization.subSectors',
                                'organization.organizationType',
                                'organization.organizationSubType',
                                'organization.wallet')->paginate(30);

        return response()->json($investor);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(InvestorDataGrid $datagrid)
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

        $investor = Investor::create(
            $request->all()
        );

        $investor->id = $organization->id;
        $investor->organization_id = $organization->id;
        $investor->save();

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
                                  'message' => 'Investor has been registered',
                                  'data' => $organization, ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FirmConsultant  $investor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $investor = Investor::with('organization',
                                    'organization.country',
                                    'organization.city',
                                    'organization.sectors',
                                    'organization.subSectors',
                                    'organization.organizationType',
                                    'organization.organizationSubType',
                                    'organization.wallet')->find($id);

        if (!$investor) {
            return response()->json([
                'error' => 1,
                'message' => 'Investor with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $investor ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FirmConsultant  $investor
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = organization::find($id);

        if (!$organization || $organization->investor) {
            return response()->json([
                'error' => 1,
                'message' => 'Investor with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_investor = $organization->investor->fill($request->all())->save();

        if ($updated && $updated_investor)
            return response()->json([
                'error' => 0,
                'message' => 'Investor has been updated',
                'data' => $organization,
            ]);

        return response()->json([
            'error' => 1,
            'message' => 'Investor could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FirmConsultant  $investor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = organization::find($id);

        if (!$organization || $organization->investor) {
            return response()->json([
                'error' => 1,
                'message' => 'Investor with id ' . $id . ' not found'
            ], 400);
        }

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Investor has been deleted'
        ]);
    }
}
