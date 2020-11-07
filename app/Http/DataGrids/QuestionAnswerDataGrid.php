<?php

namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\QuestionAnswer\QuestionAnswerResource;
use App\Model\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class QuestionAnswerDataGrid extends QueryDataGrid
{
    protected $resource = QuestionAnswerResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('paragraph')
            ->column('question')
            ->column('answer')
            ->column('resource')
            ->column('institution')
            ->column('answer_date')
            ->column('country')
            ->column('sector')
            ->column('sub_sector')
            ->column('theme')
            ->column('document_type')
            ->column('document')
            ->column('producer')
            ->column('destination')
            ->column('status');
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
        return QuestionAnswer::with('country', 'sector', 'subSector')->orderByDesc('created_at');
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
