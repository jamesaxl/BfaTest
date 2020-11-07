<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Insurance;
use App\Model\Organization;
use App\Model\Wallet;
use App\Http\Requests\Insurance\Store;
use App\Http\Requests\Insurance\Update;
use Illuminate\Support\Str;

class InsuranceController extends Controller
{
    public function index()
    {
        $insurances = Insurance::with('organization',
                                        'organization.country',
                                        'organization.city',
                                        'organization.sectors',
                                        'organization.subSectors',
                                        'organization.organizationType',
                                        'organization.organizationSubType',
                                        'organization.wallet')->paginate(30);
        return reponse()->json([ 'error' => 0,
                                 'data' => $insurances ]);
    }

    public function show($id)
    {
        $insurance = Insurance::with('organization',
                                    'organization.country',
                                    'organization.city',
                                    'organization.sectors',
                                    'organization.subSectors',
                                    'organization.organizationType',
                                    'organization.organizationSubType',
                                    'organization.wallet')->find($id);

        if (!$insurance) {
            return response()->json([
                'error' => 1,
                'message' => 'insurance with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $insurance ]);
    }

    public function store(Store $request)
    {
        $organization = Organiation::create($request->all());
        $insurance = Insurance::create($request->all());
        $insurance->id = $organization->id;
        $insurance->organizaton_id = $organization->id;
        $insurance->save();

        if ($request->hasFile('document')) {
            $organization->uploadDocument($request->file('document'));
        }

        if ($request->hasFile('photo_path')) {
            $organization->uploadDocument($request->file('photo_path'));
        }

        if (auth()->user()->account_type_id == $organization->organization_type_id) {
            auth()->user()->organization_id = $organization->id;
            auth()->user()->save();
        }

        // wallet
        $wallet = Wallet::create(
            [
                'ref' => (string) Str::uuid(),
                'organization' => $organization->id,
            ]
        );
    }

    public function update(Update $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->insurance) {
            return response()->json([
                'error' => 1,
                'message' => 'insurance with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_insurance = $organization->insurance->fill($request->all())->save();

        if ($updated && $updated_insurance) {
            if ($request->hasFile('document')) {
                if ($organization->document)
                    unlink(public_path().'/'.$organization->document);

                $organization->uploadDocument($request->file('document'));
            }

            if ($request->hasFile('photo_path')) {
                if ($organization->photo_path)
                    unlink(public_path().'/'.$organization->photo_path);

                $organization->uploadDocument($request->file('photo_path'));
            }

            return response()->json([
                'error' => 0,
                'message' => 'insurance has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'insurance could not be updated'
        ], 500);
    }

    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->insurance) {
            return response()->json([
                'error' => 1,
                'message' => 'insurance with id ' . $id . ' not found'
            ], 400);
        }

        if ($organization->document)
            unlink(public_path().'/'.$organization->document);

        if ($organization->photo_path)
            unlink(public_path().'/'.$organization->photo_path);

        $organization->delete();
        return response()->json([
                'error' => 0,
                'message' => 'insurance has been deleted'
            ]);
    }
}
