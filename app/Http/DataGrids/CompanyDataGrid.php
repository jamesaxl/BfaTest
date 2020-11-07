<?php


namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Company\CompanyResource;
use App\Model\Company;
use Illuminate\Http\Request;

class CompanyDataGrid extends QueryDataGrid
{
    protected $resource = CompanyResource::class;

    /**
     *->columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('photo_path')
            ->column('name')
            ->column('company_type')
            ->column('annual_turnover')
            ->column('evaluation')
            ->column('country_id')
            ->column('language')
            ->column('email')
            ->column('bp')
            ->column('address')
            ->column('postal_code')
            ->column('city_id')
            ->column('phone')
            ->column('fax')
            ->column('preview')
            ->column('status')
            ->column('sectors')
            ->column('sub_sectors')
            ->column('specialities')
            ->column('is_enabled');
    }

    /**
     * Get the query object.
     *
     * @param UserQuery $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Company::query()->with('organization.country',
                                        'organization.city',
                                        'organization.sectors',
                                        'organization.subSectors',
                                        'organization.organizationType',
                                        'organization.organizationSubType',
                                        'organization.specialities',
                                        'organization.qualifications')->orderByDesc('created_at');
    }

    /**
     * User of bulk action handling.
     *
     * @param $ids
     */
    public function bulkDelete($ids)
    {
    }

    public function resource($resourceClass = null)
    {
        $additional = [];

        // Handle Bulk request
        if ($this->request->hasBulkAction()) {
            $this->handleBulkAction();
        }

        // Apply filters
        if ($this->request->isFilterable()) {
            $this->applyFilters($this->request->filters(), $this->getBaseQueryBuilder());
        }

        // Require total count
        $additional['totalCount'] = $this->getBaseQueryBuilder()->count();

        // Apply sorting
        if ($this->request->isSortable()) {
            $this->applySorts($this->request->sorts());
        }

        // Apply skip
        if ($this->request->hasSkip()) {
            $this->builder->skip($this->request->skip());
        }

        // Apply take
        if ($this->request->hasTake()) {
            $this->builder->take($this->request->take());
        }

        return $this->makeResource($resourceClass, $additional);
    }
}
