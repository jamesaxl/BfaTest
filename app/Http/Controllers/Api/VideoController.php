<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Video;
use App\Http\Requests\VideoStore;
use App\Http\Requests\VideoUpdate;
use App\Http\DataGrids\VideoDataGrid;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $video = Video::with('country', 'sector', 'subSector')->paginate(30);
        return response()->json($video);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(VideoDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VideoStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoStore $request)
    {
        $user = Video::create(
            $request->all()
        );

        return response()->json(['error' => 0, 'message' => 'video has been created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::with('country', 'sector', 'subSector')->find($id);

        if (!$video) {
            return response()->json([
                'error' => 1,
                'message' => 'video with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $video ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoUpdate $request, $id)
    {
        $video = Video::find($id);

        if (!$video) {
            return response()->json([
                'error' => 1,
                'message' => 'video with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $video->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'error' => 0,
                'message' => 'video has been updated'
            ]);
        }

        else
            return response()->json([
                'error' => 1,
                'message' => 'video could not be updated'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json([
                'error' => 1,
                'message' => 'video with id ' . $id . ' not found'
            ], 400);
        }
        $video->delete();
        return response()->json([
            'error' => 0,
            'message' => 'video has been deleted'
        ]);
    }
}
