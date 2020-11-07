<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Video\VideoResource;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class VideoDataGrid extends QueryDataGrid
{
    protected $resource = VideoResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
             ->column('video_url')
             ->column('title')
            ->column('type')
            ->column('project_initiative')
            ->column('donor')
            ->column('file')
            ->column('key_words')
            ->column('country')
            ->column('sector')
            ->column('valid')
            ->column('created_at')
            ->column('sub_sector');
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

          return Video::query()->with('country', 'sector', 'subSector')->orderByDesc('created_at');


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

