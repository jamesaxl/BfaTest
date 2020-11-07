<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Media\MediaResource;
use App\Model\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MediaDataGrid extends QueryDataGrid
{
    protected $resource = MediaResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('title')
            ->column('publication_date')
            ->column('description')
            ->column('type')
            ->column('country')
            ->column('sector')
            ->column('sub_sector')
            ->column('project')
            ->column('key_words')
            ->column('file');
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
        return Media::with('project', 'country',
                           'sector', 'sub_sector')->orderByDesc('created_at');
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
