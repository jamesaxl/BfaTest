<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Consultant;
use App\Model\Opportunity;
use App\Model\Wallet;
use App\Model\Organization;
use App\Http\Requests\Consultant\Store;
use App\Http\Requests\Consultant\Update;
use App\Http\DataGrids\ConsultantDataGrid;
use Illuminate\Support\Str;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $consultants = Consultant::with('organization.country',
                                        'organization.city',
                                        'organization.sectors',
                                        'organization.subSectors',
                                        'organization.organizationType',
                                        'organization.organizationSubType',
                                        'organization.specialities',
                                        'organization.qualifications')->paginate(30);

        return response()->json($consultants);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ConsultantDataGrid $datagrid
     * @return mixed
     */
    public function indexGrid(ConsultantDataGrid $datagrid)
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
        $organization = Organization::create(
            $request->all()
        );

        $consultant = $Consultant::create(
            $request->all()
        );

        $consultant->id = $organization->id;
        $consultant->organization_id = $organization->id;
        $consultant->save();

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
        $organization->storeSubsector($subSectors);

        $specialities = $request->specialities;
        $organization->storeSpeciality($specialities);

        $qualifications = $request->qualifications;
        $organization->storeQualification($qualifications);

        // wallet
        $wallet = Wallet::create(
            [
                'ref' => (string) Str::uuid(),
                'organization_id' => $organization->id,
            ]
        );

        return response()->json([ 'error' => 0,
                                  'message' => 'Consultant has been registered',
                                  'data' => $organization, ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $consultant = Consultant::with(
                                        'organization',
                                        'organization.country',
                                        'organization.city',
                                        'organization.sectors',
                                        'organization.subSectors',
                                        'organization.organizationType',
                                        'organization.organizationSubType',
                                        'organization.specialities',
                                        'organization.wallet',
                                        'organization.qualifications')->find($id);

        if (!$consultant) {
            return response()->json([
                'error' => 1,
                'message' => 'consultant with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $consultant ]);
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

        if (!$organization || !$organization->consultant) {
            return response()->json([
                'error' => 1,
                'message' => 'Consultant with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $organization->fill($request->all())->save();
        $updated_consultant = $organization->consultant->fill($request->all())->save();

        if ($updated && $updated_consultant) {
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
            if ($subSectors) {
                $organization->subSectors()->allRelatedIds ();
                $organization->subSectors()->sync($subSectors);
                $organization->subSectors()->allRelatedIds ();
            }

            if ($request->specialities) {
                $specialities = $request->specialities;
                $organization->updateSpeciality($specialities);
            }

            if ($request->qualifications) {
                $qualifications = $request->qualifications;
                $organization->updateQualification($qualifications);
            }

            return response()->json([
                'error' => 0,
                'message' => 'Consultant has been updated',
                'data' => $organization,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'Consultant could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return mixed
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization || !$organization->consultant) {
            return response()->json([
                'error' => 1,
                'message' => 'Consultant with id ' . $id . ' not found'
            ], 400);
        }

        if ($organization->photo_path)
            unlink(public_path().'/'.$organization->photo_path);

        $organization->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Consultant has been deleted'
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function selectOpportunity($id)
    {
        $opportunity = Opportunity::with('producer', 'project',
                                         'country', 'city',
                                         'continent', 'organizations')
            ->find($id);

        if (!$opportunity) {
            return response()->json([
                'error' => 1,
                'message' => 'opportunity with id ' . $id . ' not found'
            ], 400);
        }

        $opportunitySelected = Opportunity::where('opportunities.id', $id)
            ->whereHas('organizationsOpportunities', function($q) {
                $q->where('organizations_opportunities.organization_id', auth()->user()->organization_id)
                    ->orWhere('organizations_opportunities.status', 'in', 'win, lost');
            })
            ->first();

        if ($opportunitySelected) {
            return response()->json([
                'error' => 1,
                'message' => 'opportunity with id ' . $id . ' already selected'
            ], 400);
        }

        $organizationOpportunity = OrganizationsOpportunities::create(
            [
                'organization_id' => auth()->user()->organization_id,
                'opportunity_id' => $opportunity->id,
            ]
        );

        return response()->json([
            'error' => 0,
            'message' => 'opportunity with id ' . $opportunity->id . ' has been selected'
        ]);
    }

    /**
     * @return mixed
     */
    public function getOpportunities()
    {
        $opportunities =  Opportunity::with('producer', 'project',
            'country', 'city',
            'continent', 'OrganizationsOpportunities.organization')->whereHas('organizations', function($q) {
                $q->where('organizations.id', auth()->user()->organization_id);
            })->paginate(30);

        return response()->json($opportunities);
    }

    /**
     * @return mixed
     */
    public function getWinOpportunities()
    {
        $opportunities =  Opportunity::with('producer', 'project',
            'country', 'city',
            'continent', 'OrganizationsOpportunities.organization')->whereHas('OrganizationsOpportunities', function($q) {
            $q->where('organizations_opportunities.consultant_id', auth()->user()->organization_id)
                ->where('organizations_opportunities.status', 'win');
        })->paginate(30);

        return response()->json($opportunities);
    }

    /**
     * @return mixed
     */
    public function getLostOpportunities()
    {
        $opportunities =  Opportunity::with('producer', 'project',
            'country', 'city',
            'continent', 'OrganizationsOpportunities.consultant')->whereHas('organizationsOpportunities', function($q) {
            $q->where('organizations_opportunities.organization_id', auth()->user()->organization_id)
                ->where('organizations_opportunities.status', 'lost');
        })->paginate(30);

        return response()->json($opportunities);
    }

    /**
     * @return mixed
     */
    public function getInProgressOpportunities()
    {
        $opportunities =  Opportunity::with('producer', 'project',
            'country', 'city',
            'continent', 'OrganizationsOpportunities.consultant')->whereHas('organizationsOpportunities', function($q) {
            $q->where('organizations_opportunities.organization_id', auth()->user()->organization_id)
                ->where('organizations_opportunities.status', 'in progress');
        })->paginate(30);

        return response()->json($opportunities);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function selectJob($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'error' => 1,
                'message' => 'job with id ' . $id . ' not found'
            ], 400);
        }

        $job_selected = Job::where('jobs.id', $id)
            ->whereHas('organizationsJobs', function($q) {
                $q->where('organizations_jobs.consultant_id', auth()->user()->organization_id);
            })->first();

        if ($job_selected) {
            return response()->json([
                'error' => 1,
                'message' => 'job with id ' . $id . ' already selected'
            ], 400);
        }

        $organizationJob = OrganizationsJobs::create(
            [
                'organization_id' => auth()->user()->organization_id,
                'job_id' => $job->id,
            ]
        );

        return response()->json([
            'error' => 0,
            'message' => 'job with id ' . $job->id . ' has been selected'
        ]);
    }

    /**
     * @return mixed
     */
    public function getJobs()
    {
        $jobs =  Job::with('country', 'sector',
            'user', 'organization')->whereHas('organizations', function($q) {
            $q->where('organizations.id', auth()->user()->organization_id);
        })->paginate(30);

        return response()->json($jobs);
    }
}
