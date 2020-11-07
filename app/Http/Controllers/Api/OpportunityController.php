<?php

namespace App\Http\Controllers\Api;

use App\Model\Opportunity;
use App\Model\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\DataGrids\OpportunityDataGrid;
use App\Http\Requests\OpportunityStore;
use App\Http\Requests\OpportunityUpdate;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opportunity = Opportunity::with('producer', 'project',
                                         'country', 'city',
                                         'continent')->paginate(30);

        return response()->json($opportunity);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(OpportunityDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpportunityStore $request)
    {
        $hash = Opportunity::validHash($request->acquisition_link);
        if (!$hash) {
            return response()->json([ 'error' => 1,
                                      'message' => 'Opportunity already exist'], 400);
        }

        $opportunity = Opportunity::create($request->all());
        $opportunity->hash = $hash;
        $opportunity->add_by_id = auth()->user()->id;

        if ($request->hasFile('document_path')) {
            $file = $request->file('document_path')->store('storage/opportunity_documents/'.$request->date_event);
            $opportunity->document_path = $file;
        }

        $opportunity->save();

        return response()->json([ 'error' => 0,
                                  'message' => 'Opportunity has been created',
                                  'data' => $opportunity ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $opportunity = Opportunity::with('producer', 'project', 'country', 'city', 'continent')->find($id);
        if (!$opportunity) {
            return response()->json([
                'error' => 1,
                'message' => 'opportunity with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $opportunity, ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function update(OpportunityUpdate $request, $id)
    {
        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json([
                'error' => 1,
                'message' => 'opportunity with id ' . $id . ' not found'
            ], 400);
        }

        if ($request->acquisition_link) {
            $hash = Opportunity::validHashUpdate($request->acquisition_link, $id);
            if (!$hash) {
                return response()->json([ 'error' => 1,
                    'message' => 'Opportunity already exist'], 400);
            }
        }

        $updated = $opportunity->fill($request->all())->save();

        if ($updated) {
            if ($request->hasFile('document_path')) {
                if ($opportunity->document_path)
                    unlink(public_path().'/'.$opportunity->document_path);

                $file = $request->file('document_path')->store('storage/opportunity_documents/'.$request->date_event);
                $opportunity->document_path = $file;
                $opportunity->save();
            }

            if ($request->acquisition_link) {
                $hash = Opportunity::validHashUpdate($request->acquisition_link, $id);
                $opportunity->hash = $hash;
                $opportunity->save();
            }

            return response()->json([
                'error' => 0,
                'message' => 'opportunity has been updated',
                'data' => $opportunity,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'opportunity could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return response()->json([
                'error' => 1,
                'message' => 'opportunity with id ' . $id . ' not found'
            ], 400);
        }

        if ($opportunity->document_path)
            unlink(public_path().'/'.$opportunity->document_path);

        $opportunity->delete();
        return response()->json([
                'error' => 0,
                'message' => 'user has been deleted'
            ]);
    }
}
