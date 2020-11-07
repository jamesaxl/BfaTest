<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Fund\FundResource;
use App\Model\Fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FundDataGrid extends QueryDataGrid
{
    protected $resource = FundResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('fund_name')
            ->column('intervention_sectors')
            ->column('available_amount')
            ->column('source')
            ->column('type')
            ->column('sub_type')
            ->column('fund_manager')
            ->column('fund_nature')
            ->column('sustainability')
            ->column('adaptation_mitigation_bias')
            ->column('recipients_type')
            ->column('decision_making_information')
            ->column('financial_instrument')
            ->column('monitoring_reporting_procedures')
            ->column('eligibility_criteria')
            ->column('application_timeframe')
            ->column('key_inputs_required_throughout_the_process')
            ->column('further_application_support_sources')
            ->column('recent_funded_projects_examples')
            ->column('website')
            ->column('contact_name')
            ->column('contact_email')
            ->column('contact_phone')
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
        return Fund::orderByDesc('created_at');
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
