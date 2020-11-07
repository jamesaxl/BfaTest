<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Post;
use App\Http\Requests\PostStore;
use App\Http\DataGrids\PostDataGrid;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::paginate(30);
        return response()->json($post);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(PostDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStore $request)
    {
        $post = Post::create(
            $request->all()
        );

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('storage/post_images');
            $post->image = $image_path;
            $post->save();
        }

        return response()->json(['error' => 0, 'message' => 'post has been created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'error' => 1,
                'message' => 'post with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([ 'error' => 0, 'data' => $post ]);
    }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function showByUser($user_id)
        {
            $posts = Post::where('user_id', $user_id)->paginate(30);

            if (!$posts) {
                return response()->json([
                    'error' => 1,
                    'message' => 'posts with user_id ' . $user_id . ' not found'
                ], 400);
            }

            return response()->json([ 'error' => 0, 'data' => $posts ]);
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'error' => 1,
                'message' => 'post with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $post->fill($request->all())->save();

        if ($updated) {
            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('storage/post_images');
                $post->image = $image_path;
                $post->save();
            }
            return response()->json([
                'error' => 0,
                'message' => 'post has been updated'
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'post could not be updated'
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
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'error' => 1,
                'message' => 'post with id ' . $id . ' not found'
            ], 400);
        }
        $post->delete();
        return response()->json([
            'error' => 0,
            'message' => 'post has been deleted'
        ]);
    }
}
