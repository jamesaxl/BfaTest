<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Project\ProjectResource;
use App\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProjectDataGrid extends QueryDataGrid
{
    protected $resource = ProjectResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('continent')
            ->column('country')
            ->column('city')
            ->column('region')
            ->column('sector')
            ->column('sub_sector')
            ->column('donor')
            ->column('name')
            ->column('analytic_summary')
            ->column('acquisition_summary_modalities')
            ->column('risks_related_to_acquisitions')
            ->column('sector_market_analysis')
            ->column('progress')
            ->column('executing_agency')
            ->column('boss_name')
            ->column('executing_agency_email')
            ->column('executing_agency_phone')
            ->column('website')
            ->column('decision_maker_name_in_country')
            ->column('email_decision_maker')
            ->column('phone_decision_maker')
            ->column('division_in_charge_of_the_project_at_the_donor')
            ->column('project_status')
            ->column('approval_date')
            ->column('effective_first_disbursement')
            ->column('actual_first_disbursement')
            ->column('latest_disbursement')
            ->column('planned_project_completion_date')
            ->column('original_closing_date')
            ->column('planned_final_disbursement_date')
            ->column('amount_not_disbursed')
            ->column('task_manager_name')
            ->column('task_manager_email')
            ->column('window_funds')
            ->column('disbursement_rate')
            ->column('amount')
            ->column('currency')
            ->column('loan_number')
            ->column('entry_into_force')
            ->column('total_undisb')
            ->column('rd_regional_dept')
            ->column('loans_exchange_rate_date')
            ->column('sector_dept')
            ->column('project_age_in_years')
            ->column('par_report')
            ->column('annex')
            ->column('file')
            ->column('ppm')
            ->column('valid')
            ->column('project_geo');
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
        return Project::query()->with('continent',
                                    'country', 'city', 'sector',
                                    'subSector')->orderByDesc('created_at');
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
