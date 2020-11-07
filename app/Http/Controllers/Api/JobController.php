<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Job;
use App\User;
use App\Http\Requests\Job\Store;
use App\Http\Requests\Job\Update;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('country', 'sector')->paginate(30);
        return response()->json(['error' => 0, 'data' => $jobs]);
    }

    public function show($id)
    {
        $job = Job::with('country', 'sector')->find($id);

        if (!$job) {
            return response()->json([
                'error' => 1,
                'message' => 'job with ID '.$id.' not found'],
                400);
        }

        return response()->json(['error' => 0, 'data' => $job]);
    }

    public function store(Store $request)
    {
        $job = Job::create($request->all());

        return response()->json(
            [
                'error' => 0,
                'message' => 'job has been registered',
                'data' => $job
            ]);
    }

    public function update(Update $request, $id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'error' => 1,
                'message' => 'job with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $job->fill($request->all())->save();

        if ($updated) {

            $jobs = Job::with('country', 'sector')->paginate(30);
            return response()->json([
                'error' => 0,
                'message' => 'job has been updated',
                'data' => $job,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'job could not be updated'
        ], 500);
    }

    public function delete($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'error' => 1,
                'message' => 'job with ID '.$id.' not found'],
                400);
        }

        $job->delete();
        return response()->json(['error' => 0, 'message' => 'job has been deleted']);
    }
}
