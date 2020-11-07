<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\SubSector\SubSectorResource;
use App\Model\SubSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SubSectorDataGrid extends QueryDataGrid
{
    protected $resource = SubSectorResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('name')
            ->column('sector');
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
        return SubSector::with('sector')->orderByDesc('created_at');

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
