<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\FirmConsultant;
use App\Model\Wallet;
use App\Model\ManyToMany\FirmConsultant\FirmConsultantSector;
use App\Model\ManyToMany\FirmConsultant\FirmConsultantSubSector;
use App\Model\ManyToMany\FirmConsultant\FirmConsultantQualification;
use App\Model\ManyToMany\FirmConsultant\FirmConsultantSpeciality;
use App\Model\Oganization;
use App\Http\Requests\FirmConsultant\Store;
use App\Http\Requests\FirmConsultant\Update;
use App\Http\DataGrids\FirmConsultantDataGrid;
use Illuminate\Support\Str;

class FirmConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultants = FirmConsultant::with(
                                        'organization',
                                        'organization.country',
                                        'organization.city',
                                        'organization.sectors',
                                        'organization.subSectors',
                                        'organization.organizationType',
                                        'organization.organizationSubType',
                                        'organization.wallet')->paginate(30);

        return response()->json($consultants);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(FirmConsultantDataGrid $datagrid)
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

        $firmConsultant = FirmConsultant::create(
            $request->all()
        );

        $firmConsultant->id = $organization->id;
        $firmConsultant->organization_id = $organization->id;
        $firmConsultant->save();

        if ($request->hasFile('photo_path')) {
            $organization->uploadLogo($request->file('photo_path'));
        }

        $sectors = $request->sectors;
        $organization->storeSector($sectors);

        $subSectors = $request->sub_sectors;
        $organization->storeSubsector($subSectors);

        $specialities = $request->specialities;
        $organization->storeSpecialitie($specialities);

        $qualifications = $request->qualifications;
        $organization->storeQualification($qualifications);

        if (auth()->user()->account_type_id == $organization->organization_type_id) {
            auth()->user()->organization_id = $organization->id;
            auth()->user()->save();
        }

        // wallet
        $wallet = Wallet::create(
            [
                'ref' => (string) Str::uuid(),
                'organization_id' => $organization>id,
            ]
        );

        return response()->json([ 'error' => 0,
            'message' => 'form-consultant has been registered',
            'data' => $organization,]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Consultant  $consultant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consultant = Consultant::with('organization.country',
                                        'organization.city',
                                        'organization.sectors',
                                        'organization.subSectors',
                                        'organization.organizationType',
                                        'organization.organizationSubType',
                                        'organization.wallet')->find($id);

        if (!$consultant) {
            return response()->json([
                'error' => 1,
                'message' => 'firm-consultant with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json([ 'error' => 0, 'data' => $consultant ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Consultant  $consultant
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->firmConsultant) {
            return response()->json([
                'error' => 1,
                'message' => 'firm-consultant with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updatedFirmConsultant = $organization->firmConsultant->fill($request->all())->save();

        if ($updated && $updatedFirmConsultant) {
            if ($request->hasFile('photo_path')) {
                if ($organization->photo_path)
                    unlink(public_path().'/'.$organization->photo_path);

                $organization->uploadLogo($request->file('photo_path'));;
            }

            $sectors = $request->sectores;
            if ($sectors) {
                $organization->sectors()->allRelatedIds ();
                $organization->sectors()->sync($sectors);
                $organization->sectors()->allRelatedIds ();
            }

            $subSectors = $request->sub_sectores;
            if ($subSectors) {
                $organization->subSectors()->allRelatedIds ();
                $organization->subSectors()->sync($subSectors);
                $organization->subSectors()->allRelatedIds ();
            }

            $specialities = $request->specialities;
            if ($specialities) {
                $organization->updateSpecialitie($specialities);
            }

            $qualifications = $request->qualifications;
            if ($qualifications) {
                $organization->updateQualification($qualifications);
            }

            $organization = Organization::find($id);
            return response()->json([
                'error' => 0,
                'message' => 'firm-consultant has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'firm-consultant could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Consultant  $consultant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization && $organization->firmConsultant) {
            return response()->json([
                'error' => 1,
                'message' => 'firm-consultant with id ' . $id . ' not found'
            ], 400);
        }

        if ($organization->photo_path)
            unlink(public_path().'/'.$organization->photo_path);

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'firm-consultant has been deleted'
        ]);
    }
}
