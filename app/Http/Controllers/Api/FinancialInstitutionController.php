<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Wallet;
use App\Model\FinancialInstitution;
use App\Model\Organization;
use App\Http\Requests\FinancialInstitution\Store;
use App\Http\Requests\FinancialInstitution\Update;
use Illuminate\Support\Str;

class FinancialInstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financial_institution = FinancialInstitution::with(
                                'organization',
                                'organization.country',
                                'organization.city',
                                'organization.sectors',
                                'organization.subSectors',
                                'organization.organizationType',
                                'organization.organizationSubType',
                                'organization.wallet')->paginate(30);

        return response()->json($financial_institution);
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

        $financial_institution = FinancialInstitution::create(
            $request->all()
        );

        $financial_institution->id = $organization->id;
        $financial_institution->organization_id = $organization->id;
        $financial_institution->save();

        if ($request->hasFile('photo_path')) {
            Organization::uploadLogo($organization, $request->file('photo_path'));
        }

        if (auth()->user()->account_type_id == $organization->organization_type_id) {
            auth()->user()->organization_id = $organization->id;
            auth()->user()->save();
        }

        // wallet
        $wallet = Wallet::create(
            [
                'ref' => (string) Str::uuid(),
                'organization_id' => $organization,
            ]
        );

        return response()->json([ 'error' => 0,
                                  'message' => 'FinancialInstitution has been registered',
                                  'data' => $organization, ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FinancialInstitution  $financial_institution
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $financial_institution = FinancialInstitution::with('organization.country',
                                                'organization.city',
                                                'organization.sectors',
                                                'organization.subSectors',
                                                'organization.organizationType',
                                                'organization.organizationSubType',
                                                'organization.wallet')->find($id);
        return response()->json([ 'error' => 0, 'data' => $financial_institution ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FinancialInstitution  $financial_institution
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->financial_institution) {
            return response()->json([
                'error' => 1,
                'message' => 'FinancialInstitution with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_financial_institution = $organization->financial_institution
                                          ->fill($request->all())->save();

        if ($updated && $updated_financial_institution) {
            if ($request->hasFile('photo_path')) {
                if ($organization->photo_path)
                    unlink(public_path().'/'.$organization->photo_path);

                Organization::uploadLogo($organization, $request->file('photo_path'));
            }

            $organization = Organization::find($id);
            return response()->json([
                'error' => 0,
                'message' => 'FinancialInstitution has been updated',
                'data' => $organization,
            ]);
        }
        return response()->json([
            'error' => 1,
            'message' => 'FinancialInstitution could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FinancialInstitution  $financial_institution
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->financial_institution) {
            return response()->json([
                'error' => 1,
                'message' => 'FinancialInstitution with id ' . $id . ' not found'
            ], 400);
        }

        if ($organization->photo_path)
            unlink(public_path().'/'.$organization->photo_path);

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'FinancialInstitution has been deleted'
        ]);
    }
}
