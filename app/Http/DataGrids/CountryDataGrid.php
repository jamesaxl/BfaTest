<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Country\CountryResource;
use App\Model\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CountryDataGrid extends QueryDataGrid
{
    protected $resource = CountryResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
             ->column('name');
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

        return Country::orderByDesc('created_at');


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
