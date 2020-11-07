<?php

namespace App\Http\Controllers\Api;

use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wallet;
use App\Http\Requests\Supplier\Store;
use App\Http\Requests\Supplier\Update;
use App\Model\Organization;
use App\Http\DataGrids\SupplierDataGrid;
use Illuminate\Support\Str;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::with('organization',
                                    'organization.country',
                                    'organization.nationality',
                                    'organization.city',
                                    'organization.sectors',
                                    'organization.subSectors',
                                    'organization.organizationType',
                                    'organization.organizationSubType',
                                    'organization.wallet')->paginate(30);

        return response()->json($supplier);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(SupplierDataGrid $datagrid)
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

        $supplier = Supplier::create(
            $request->all()
        );

        $supplier->id = $organization->id;
        $supplier->organization_id = $organization->id;
        $supplier->save();

        if ($request->hasFile('photo_path')) {
            $organization->uploadLogo($request->file('photo_path'));
        }

        $sectors = $request->sectors;
        $organization->storeSector($sectors);

        $subSectors = $request->sub_sectors;
        $organization->storeSubSector($subSectors);

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
                                  'message' => 'supplier has been registered',
                                  'supplier' => $organization]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::with('organization',
                                    'organization.nationality',
                                    'organization.country',
                                    'organization.city',
                                    'organization.sectors',
                                    'organization.subSectors',
                                    'organization.organizationType',
                                    'organization.organizationSubType',
                                    'organization.wallet')->find($id);

        if (!$supplier) {
            return response()->json([
                'error' => 1,
                'message' => 'supplier with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $supplier ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || $organization->supplier) {
            return response()->json([
                'error' => 1,
                'message' => 'supplier with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_supplier = $organization->fill($request->all())->save();

        if ($updated && $updated_supplier) {
            if ($request->hasFile('photo_path')) {
                if ($organization->photo_path)
                    unlink(public_path().'/'.$organization->photo_path);

                $organization->uploadLogo($request->file('photo_path'));
            }

            $sectors = $request->sectors;
            if ($sectors) {
                $organization->sectors()->allRelatedIds ();
                $organization->sectors()->sync($sectors);
                $organization->sectors()->allRelatedIds ();
            }

            $subSectors = $request->sub_sectors;
            if ($subSectors){
                $organization->subSectors()->allRelatedIds ();
                $organization->subSectors()->sync($subSectors);
                $organization->subSectors()->allRelatedIds ();
            }

            $specialities = $request->specialities;
            if ($specialities) {
                $organization->updateSpeciality($specialities);
            }

            return response()->json([
                'error' => 0,
                'message' => 'supplier has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'supplier could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || $organization->supplier) {
            return response()->json([
                'error' => 1,
                'message' => 'supplier with id ' . $id . ' not found'
            ], 400);
        }

        if ($organization->photo_path)
            unlink(public_path().'/'.$organization->photo_path);

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Supplier has been deleted'
        ]);
    }
}
