<?php

namespace App\Http\Controllers\Api;

use App\Model\Company;
use App\Model\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\Company\Store;
use App\Http\Requests\Company\Update;
use App\Http\Controllers\Controller;
use App\Model\Wallet;
use App\Http\DataGrids\CompanyDataGrid;
use DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        DB::beginTransaction();
        try {
            $companies = Company::with(
                'organization.country',
                'organization.responsible',
                'organization.responsible',
                'organization.city',
                'organization.sectors',
                'organization.subSectors',
                'organization.organizationType',
                'organization.organizationSubType',
                'organization.wallet',
                'organization.specialities')->paginate(30);
            DB::commit();
            return response()->json($companies);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => 1, 'message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param CompanyDataGrid $datagrid
     * @return mixed
     */
    public function indexGrid(CompanyDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return mixed
     */
    public function store(Store $request)
    {
        try {
            $organization = Organization::create($request->all());

            $company = Company::create([
                'id' => $organization->id,
                'organization_id' => $organization->id,
            ]);


            if ($request->hasFile('photo_path')) {
                $organization->uploadLogo($request->file('photo_path'));
            }

            if (auth()->user()->account_type_id == $organization->organization_type_id) {
                auth()->user()->organization_id = $organization->id;
                auth()->user()->save();
            }

            $sectors = $request->sectors;
            $organization->storeSector($sectors);

            $subSectors = $request->sub_sectors;
            $organization->storeSector($subSectors);

            $specialities = $request->specialities;
            $organization->storeSpeciality($specialities);

            // wallet
            $organization->setupWallet();

            return response()->json([ 'error' => 0,
                'message' => 'Company has been registered',
                'data' => $company]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => 1, 'message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return mixed
     */
    public function show($id)
    {
        $company = Company::with(
                        'organization',
                        'organization.responsible',
                        'organization.country',
                        'organization.city',
                        'organization.sectors',
                        'organization.subSectors',
                        'organization.organizationType',
                        'organization.wallet',
                        'organization.specialities')->find($id);

        if (!$company) {
            return response()->json([
                'error' => 1,
                'message' => 'company with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $company ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Update $request
     * @param $id
     * @return mixed
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->company) {
            return response()->json([
                'error' => 1,
                'message' => 'company with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_company = $organization->company->fill($request->all())->save();

        if ($updated && $updated_company) {

            if ($request->sectors) {
                $organization->sectors()->allRelatedIds();
                $organization->sectors()->sync($request->sectors);
                $organization->sectors()->allRelatedIds();
            }

            if ($request->sub_sectors) {
                $organization->subSectors()->allRelatedIds ();
                $organization->subSectors()->sync($request->sub_sectors);
                $organization->subSectors()->allRelatedIds ();
            }

            if ($request->specialities) {
                $specialities = $request->specialities;
                $organization->updateSpeciality($specialities);
            }


            if ($request->hasFile('photo_path')) {
                if ($organization->photo_path)
                    unlink(public_path().'/'.$organization->photo_path);

                $organization->uploadLogo($request->file('photo_path'));
            }

            return response()->json([
                'error' => 0,
                'message' => 'company has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'company could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        if (!$organization ||!$organization->company) {
            return response()->json([
                'error' => 1,
                'message' => 'Company with id ' . $id . ' not found'
            ], 400);
        }
        if ($organization->photo_path)
            unlink(public_path().'/'.$company->photo_path);

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Company has been deleted'
        ]);
    }
}
