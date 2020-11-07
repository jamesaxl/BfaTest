<?php

namespace App\Http\Controllers\Api;

use App\Model\Media;
use Illuminate\Http\Request;
use App\Http\DataGrids\MediaDataGrid;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medias = Media::with('project', 'country',
                              'sector', 'subSector')->paginate(30);
        return response()->json($medias);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(MediaDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $media = Media::create(
            $request->all()
        );

        return response()->json([
            'error' => 0,
            'message' => 'media has been registered'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Sector  $media
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media = Media::with('project', 'country',
                             'sector', 'subSector')->where('id', $id)->first();
        if (!$media) {
            return response()->json([
                'error' => 1,
                'message' => 'media with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $media ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Sector  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json([
                'error' => 1,
                'message' => 'media with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $media->fill($request->all())->save();

        if ($updated) {

            return response()->json([
                'error' => 0,
                'message' => 'media has been updated'
            ]);
        } else {
            return response()->json([
                'error' => 1,
                'message' => 'media could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Sector  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json([
                'error' => 1,
                'message' => 'media with id ' . $id . ' not found'
            ], 400);
        }

        $media->delete();
        return response()->json([
            'error' => 0,
            'message' => 'media has been deleted'
        ]);
    }
}
