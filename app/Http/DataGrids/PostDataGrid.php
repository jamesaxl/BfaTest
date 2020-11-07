<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Post\PostResource;
use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PostDataGrid extends QueryDataGrid
{
    protected $resource = PostResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
             ->column('title')
             ->column('image')
             ->column('content')
            ->column('created_at')
             ->column('description');
    }

    /**
     * Get the query object.
     *
     * @param UserQuery $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query(Request $request)
    {
//        dd($request->route('type'));

          return Post::query()->orderByDesc('created_at');


//       return Team::query()->orderByDesc('created_at');
    }

    /**
     * User of bulk action handling.
     *
     * @param $ids
     */
    public function bulkDelete($ids)
    {
    }

}

