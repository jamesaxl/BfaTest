<?php

namespace App\Http\Controllers\Api;

use App\Model\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\DataGrids\ProjectDataGrid;
use App\Http\Requests\ProjectStore;
use App\Http\Requests\ProjectUpdate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('opportunities', 'continent',
            'country', 'city', 'sector',
            'subSector')->paginate(30);
        return response()->json($projects);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\Response
     */
    public function indexAll()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(ProjectDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectStore $request
     * @return Illuminate\Http\Response
     */
    public function store(ProjectStore $request)
    {
        $hash = Project::validHash($request->project_link);
        if (!$hash) {
            return response()->json([ 'error' => 1,
                'message' => 'Project already exist'], 400);
        }

        $project = Project::create($request->all());
        $project->hash = $hash;

//        if ($request->hasFile('file')) {
//            $file = $request->file('file')->store('storage/project_file');
//            $project->file = $file;
//        }


        if ($request->hasFile('par_report')) {
            $file = $request->file('par_report')->store('storage/project/par_report/'.$project->date_event.'/'.$project->name);
            $project->par_report = $file;
        }

        if ($request->hasFile('annex')) {
            $file = $request->file('annex')->store('storage/project/annex/'.$project->date_event.'/'.$project->name);
            $project->annex = $file;
        }

        if ($request->hasFile('ppm')) {
            $file = $request->file('ppm')->store('storage/project/ppm/'.$project->date_event.'/'.$project->name);
            $project->ppm = $file;
        }

        $project->add_by_id = auth()->user()->id;
        $project->save();

        return response()->json([ 'error' => 0,
            'message' => 'Project has been created',
            'data' => $project]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('country', 'city', 'continent')->find($id);
        if (!$project) {
            return response()->json([
                'error' => 1,
                'message' => 'project with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $project ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'error' => 1,
                'message' => 'project with id ' . $id . ' not found'
            ], 400);
        }

        if ($request->project_link) {
            $hash = Project::validHashUpdate($request->project_link, $id);
            if (!$hash) {
                return response()->json([ 'error' => 1,
                    'message' => 'Opportunity already exist'], 400);
            }
        }

        $updated = $project->fill($request->all())->save();

        if ($updated) {
//            if ($request->hasFile('file')) {
//                $file = $request->file('file')->store('storage/project_file');
//                $project->file = $file;
//                $project->save();
//            }



            if ($request->hasFile('par_report')) {
                if ($project->par_report)
                    unlink(public_path().'/'.$project->par_report);

                $file = $request->file('par_report')->store('storage/project/par_report/'.$project->date_event.'/'.$project->name);
                $project->par_report = $file;
            }

            if ($request->hasFile('annex')) {
                if ($project->annex)
                    unlink(public_path().'/'.$project->annex);

                $file = $request->file('annex')->store('storage/project/annex/'.$project->date_event.'/'.$project->name);
                $project->annex = $file;
            }

            if ($request->hasFile('ppm')) {
                if ($project->ppm)
                    unlink(public_path().'/'.$project->ppm);

                $file = $request->file('ppm')->store('storage/project/ppm/'.$project->date_event.'/'.$project->name);
                $project->ppm = $file;
            }

            if ($request->project_link) {
                $hash = Prokect::validHashUpdate($request->project_link, $id);
                $project->hash = $hash;
                $project->save();
            }

            $project->save();

            return response()->json([
                'error' => 0,
                'message' => 'project has been updated',
                'data' => $project
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'project could not be updated'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'error' => 1,
                'message' => 'project with id ' . $id . ' not found'
            ], 400);
        }

        if ($project->ppm)
            unlink(public_path().'/'.$project->ppm);

        if ($project->annex)
            unlink(public_path().'/'.$project->annex);

        if ($project->par_report)
            unlink(public_path().'/'.$project->par_report);

        $project->delete();
        return response()->json([
            'error' => 0,
            'message' => 'project has been deleted'
        ]);
    }
}
