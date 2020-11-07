<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Opportunity\OpportunityResource;
use App\Model\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OpportunityDataGrid extends QueryDataGrid
{
    protected $resource = OpportunityResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('hash')
            ->column('continent')
            ->column('country')
            ->column('city')
            ->column('project')
            ->column('sector')
            ->column('producer')
            ->column('title_acquisition')
            ->column('geo_location')
            ->column('ref')
            ->column('executing_agency')
            ->column('executing_agency_email')
            ->column('executing_agency_phone')
            ->column('executing_agency_address')
            ->column('link_acquisition')
            ->column('category_acquisition')
            ->column('document_type')
            ->column('type_acquisition')
            ->column('description_acquisition')
            ->column('information_acquisition')
            ->column('progress')
            ->column('selection_mode')
            ->column('ftq')
            ->column('publication_date')
            ->column('estimated_date_event_delivery')
            ->column('estimated_date_event_discount')
            ->column('lot_number')
            ->column('estimated_amount_currency')
            ->column('euro_exchange_rate')
            ->column('estimated_amount_euro')
            ->column('date_sign_contract')
            ->column('start_date')
            ->column('submission_date')
            ->column('country_decision_maker_name')
            ->column('task_manager_name')
            ->column('status')
            ->column('document_path')
            ->column('document_extension');
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
        return Opportunity::with('producer', 'project',
                                 'sector',
                                 'country', 'city',
                                 'continent')->orderByDesc('created_at');
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
        // Additional resource data
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

